<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function getOptions(Request $request, ShippingService $shipping)
    {
        $request->validate([
            'country' => 'required|string',
            'city_id' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $totalWeight = $cartItems->sum(fn($c) => $c->product->weight * $c->quantity);

        $options = $shipping->getOptions(
            $request->country,
            $request->city_id ?? '',
            $totalWeight
        );

        return response()->json(['success' => true, 'options' => $options]);
    }

    public function getCities(ShippingService $shipping)
    {
        return response()->json(['success' => true, 'cities' => $shipping->getCities()]);
    }
}
