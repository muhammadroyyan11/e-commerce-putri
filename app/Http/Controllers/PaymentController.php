<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function select(Order $order)
    {
        // Only owner can access
        abort_if($order->customer_email !== auth()->user()->email, 403);
        abort_if($order->payment_token, 302, route('payment.detail', $order));

        return view('pages.payment-select', compact('order'));
    }

    public function process(Request $request, Order $order, MidtransService $midtrans)
    {
        abort_if($order->customer_email !== auth()->user()->email, 403);

        $request->validate(['payment_method' => 'required|string']);

        $method = $request->payment_method;

        try {
            $result = match ($method) {
                'bca'        => $midtrans->chargeVA($order, 'bca'),
                'bni'        => $midtrans->chargeVA($order, 'bni'),
                'bri'        => $midtrans->chargeVA($order, 'bri'),
                'permata'    => $midtrans->chargeVA($order, 'permata'),
                'mandiri'    => $midtrans->charge($order, 'echannel', [
                    'echannel' => ['bill_info1' => 'Payment', 'bill_info2' => 'Online'],
                ]),
                'gopay'      => $midtrans->chargeGopay($order),
                'qris'       => $midtrans->chargeQris($order),
                'shopeepay'  => $midtrans->chargeShopeepay($order),
                'alfamart'   => $midtrans->chargeAlfamart($order),
                'indomaret'  => $midtrans->chargeIndomaret($order),
                default      => throw new \InvalidArgumentException('Invalid payment method'),
            };

            if (isset($result['status_code']) && !in_array($result['status_code'], ['200', '201'])) {
                return back()->with('error', $result['status_message'] ?? 'Gagal memproses pembayaran.');
            }

            $parsed = $midtrans->parseChargeResult($result);
            $order->update($parsed);

            return redirect()->route('payment.detail', $order);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function detail(Order $order)
    {
        abort_if($order->customer_email !== auth()->user()->email, 403);
        return view('pages.payment-detail', compact('order'));
    }
}
