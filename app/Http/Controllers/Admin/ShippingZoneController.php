<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::orderBy('sort_order')->get();
        return view('admin.shipping-zones.index', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'countries_text'=> 'required|string',
            'flat_rate'     => 'required|numeric|min:0',
            'sort_order'    => 'nullable|integer',
        ]);

        ShippingZone::create([
            'name'       => $request->name,
            'countries'  => array_filter(array_map('trim', explode("\n", $request->countries_text))),
            'flat_rate'  => $request->flat_rate,
            'is_active'  => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Zona pengiriman berhasil ditambahkan.');
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'countries_text'=> 'required|string',
            'flat_rate'     => 'required|numeric|min:0',
            'sort_order'    => 'nullable|integer',
        ]);

        $shippingZone->update([
            'name'       => $request->name,
            'countries'  => array_filter(array_map('trim', explode("\n", $request->countries_text))),
            'flat_rate'  => $request->flat_rate,
            'is_active'  => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Zona pengiriman berhasil diperbarui.');
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();
        return back()->with('success', 'Zona pengiriman berhasil dihapus.');
    }
}
