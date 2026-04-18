<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get()->map(function ($cart) {
            $product = $cart->product;
            return [
                'id'             => $product->id,
                'name'           => $product->name,
                'slug'           => $product->slug,
                'price'          => $product->price,
                'original_price' => $product->original_price,
                'quantity'       => $cart->quantity,
                'size'           => 'Standar',
                'sku'            => 'TH-' . strtoupper(substr($product->slug, 0, 3)) . '-' . str_pad($product->id, 3, '0', STR_PAD_LEFT),
                'image'          => $product->image ?? 'https://via.placeholder.com/100',
                'category_id'    => $product->category_id,
            ];
        })->toArray();

        $summary = $this->calculateSummary($cartItems);

        // F3: Related products — from same categories as cart items, exclude cart products
        $cartProductIds    = collect($cartItems)->pluck('id')->toArray();
        $cartCategoryIds   = collect($cartItems)->pluck('category_id')->unique()->toArray();
        $relatedProducts   = Product::with(['category','images'])
            ->whereIn('category_id', $cartCategoryIds)
            ->whereNotIn('id', $cartProductIds)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get()
            ->map(fn($p) => [
                'id'             => $p->id,
                'name'           => $p->name,
                'slug'           => $p->slug,
                'category'       => $p->category?->name ?? '',
                'price'          => $p->price,
                'original_price' => $p->original_price,
                'discount'       => $p->discount,
                'image'          => $p->primaryImage()?->url ?? $p->image ?? 'https://via.placeholder.com/400x500',
                'badge'          => $p->badge,
            ]);

        return view('pages.cart', compact('cartItems', 'summary', 'relatedProducts'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        if ($request->input('action') === 'increase') {
            $cart->quantity += 1;
        } elseif ($request->input('action') === 'decrease') {
            $cart->quantity -= 1;
            if ($cart->quantity <= 0) {
                $cart->delete();
                return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
            }
        } else {
            $cart->quantity = max(1, $request->input('quantity', 1));
        }

        $cart->save();

        return redirect()->route('cart')->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove(Request $request)
    {
        Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->delete();

        return redirect()->route('cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    private function calculateSummary($items)
    {
        $subtotal = 0;
        $discount = 0;

        foreach ($items as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;

            if ($item['original_price']) {
                $itemDiscount = ($item['original_price'] - $item['price']) * $item['quantity'];
                $discount += $itemDiscount;
            }
        }

        $shipping = $subtotal > 200000 ? 0 : 25000;
        $total = $subtotal + $shipping;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'item_count' => count($items),
        ];
    }
}
