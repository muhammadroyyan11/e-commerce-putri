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

        try {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            $totalWeight = max(500, $cartItems->sum(fn($c) => ($c->product->weight ?? 500) * $c->quantity));

            $options = $shipping->getOptions(
                $request->country,
                $request->city_id ?? '',
                $totalWeight
            );

            return response()->json(['success' => true, 'options' => $options]);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'options' => [
                ['courier' => 'flat', 'service' => 'Reguler', 'description' => 'Flat Rate', 'cost' => 25000, 'etd' => '3-5 hari']
            ]]);
        }
    }

    public function getCities(ShippingService $shipping)
    {
        return response()->json(['success' => true, 'cities' => $shipping->getCities()]);
    }
}
