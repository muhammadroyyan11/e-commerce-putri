<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('services.midtrans.server_key');
        MidtransConfig::$isProduction = config('services.midtrans.is_production');
        MidtransConfig::$isSanitized = config('services.midtrans.is_sanitized');
        MidtransConfig::$is3ds = config('services.midtrans.is_3ds');
    }

    public function index()
    {
        $cartItems = $this->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $summary = $this->calculateSummary($cartItems);
        $paymentMethods = PaymentMethod::active()->get();

        return view('pages.checkout', compact('cartItems', 'summary', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        $validated = $request->validate([
            'email'             => 'required|email',
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'address'           => 'required|string',
            'city'              => 'required|string',
            'province'          => 'required|string',
            'country'           => 'required|string',
            'postal_code'       => 'required|string',
            'phone'             => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'shipping_cost'     => 'required|numeric|min:0',
            'shipping_courier'  => 'nullable|string',
            'shipping_service'  => 'nullable|string',
            'shipping_etd'      => 'nullable|string',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);
        $summary = $this->calculateSummaryFromDb($cartItems);

        // Use shipping cost from form (calculated via AJAX)
        $shippingCost = (float) $validated['shipping_cost'];

        // Apply coupon if provided
        $couponCode = null;
        $couponDiscount = 0;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid() && $summary['subtotal'] >= $coupon->min_order) {
                $couponDiscount = $coupon->calculateDiscount($summary['subtotal']);
                $couponCode = $coupon->code;
                $coupon->increment('used_count');
            }
        }

        $total = max(0, $summary['subtotal'] + $shippingCost - $couponDiscount);

        $order = Order::create([
            'order_number'      => 'GH-' . date('Y') . '-' . rand(1000, 9999),
            'customer_name'     => $validated['first_name'] . ' ' . $validated['last_name'],
            'customer_email'    => $validated['email'],
            'customer_phone'    => $validated['phone'],
            'address'           => $validated['address'],
            'city'              => $validated['city'],
            'province'          => $validated['province'],
            'country'           => $validated['country'],
            'postal_code'       => $validated['postal_code'],
            'payment_method'    => $paymentMethod->name,
            'payment_method_id' => $paymentMethod->id,
            'status'            => 'pending',
            'subtotal'          => $summary['subtotal'],
            'discount'          => $summary['discount'],
            'shipping'          => $shippingCost,
            'total'             => $total,
            'notes'             => $request->input('notes'),
            'coupon_code'       => $couponCode,
            'coupon_discount'   => $couponDiscount,
            'shipping_courier'  => $validated['shipping_courier'],
            'shipping_service'  => $validated['shipping_service'],
            'shipping_etd'      => $validated['shipping_etd'],
        ]);

        foreach ($cartItems as $cart) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_name'  => $cart->product->name,
                'product_price' => $cart->product->price,
                'quantity'      => $cart->quantity,
                'subtotal'      => $cart->product->price * $cart->quantity,
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        if ($paymentMethod->isMidtrans()) {
            return redirect()->route('payment.select', $order);
        }

        return redirect()->route('order.success')->with('order', $order);
    }

    private function redirectToMidtrans(Order $order, array $customer): \Illuminate\Http\RedirectResponse
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $customer['first_name'],
                'last_name'  => $customer['last_name'],
                'email'      => $customer['email'],
                'phone'      => $customer['phone'],
            ],
        ];

        $snapUrl = Snap::createTransaction($params)->redirect_url;

        return redirect($snapUrl);
    }

    public function success()
    {
        $order = session('order');

        if (!$order) {
            $order = [
                'number'         => 'GH-' . date('Y') . '-' . rand(1000, 9999),
                'date'           => now()->format('d F Y'),
                'total'          => 0,
                'payment_method' => '-',
                'payment_type'   => 'manual',
                'id'             => null,
            ];
        } elseif ($order instanceof Order) {
            $order = [
                'id'             => $order->id,
                'number'         => $order->order_number,
                'date'           => $order->created_at->format('d F Y'),
                'total'          => $order->total,
                'payment_method' => $order->paymentMethod?->name ?? $order->payment_method,
                'payment_type'   => $order->paymentMethod?->type ?? 'manual',
            ];
        }

        return view('pages.order-success', compact('order'));
    }

    private function getCartItems()
    {
        return Cart::with('product')->where('user_id', auth()->id())->get()->map(function ($cart) {
            $product = $cart->product;
            return [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $cart->quantity,
                'variant'  => 'Standar',
                'image'    => $product->image ?? 'https://via.placeholder.com/80',
            ];
        })->toArray();
    }

    private function calculateSummary($items)
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shipping = $subtotal > 200000 ? 0 : 25000;

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total'    => $subtotal + $shipping,
        ];
    }

    private function calculateSummaryFromDb($cartItems)
    {
        $subtotal = 0;
        $discount = 0;

        foreach ($cartItems as $cart) {
            $subtotal += $cart->product->price * $cart->quantity;
            if ($cart->product->original_price) {
                $discount += ($cart->product->original_price - $cart->product->price) * $cart->quantity;
            }
        }

        $shipping = $subtotal > 200000 ? 0 : 25000;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total'    => $subtotal + $shipping,
        ];
    }
}
