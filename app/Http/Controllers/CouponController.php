<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json(['success' => false, 'message' => 'Coupon tidak valid atau sudah kadaluarsa.']);
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn($c) => $c->product->price * $c->quantity);

        if ($subtotal < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order Rp ' . number_format($coupon->min_order, 0, ',', '.') . ' untuk coupon ini.',
            ]);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json([
            'success'  => true,
            'message'  => 'Coupon berhasil diterapkan!',
            'code'     => $coupon->code,
            'discount' => $discount,
            'discount_formatted' => 'Rp ' . number_format($discount, 0, ',', '.'),
        ]);
    }
}
