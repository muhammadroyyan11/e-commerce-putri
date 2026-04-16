<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|size:5|unique:coupons,code|regex:/^[A-Z0-9]+$/',
            'description' => 'nullable|string|max:255',
            'type'        => 'required|in:percent,fixed',
            'value'       => 'required|numeric|min:1',
            'min_order'   => 'nullable|numeric|min:0',
            'max_discount'=> 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from'  => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active'   => 'boolean',
        ]);

        Coupon::create([
            'code'         => strtoupper($request->code),
            'description'  => $request->description,
            'type'         => $request->type,
            'value'        => $request->value,
            'min_order'    => $request->min_order ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit'  => $request->usage_limit,
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil dibuat.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code'        => 'required|string|size:5|unique:coupons,code,' . $coupon->id . '|regex:/^[A-Z0-9]+$/',
            'description' => 'nullable|string|max:255',
            'type'        => 'required|in:percent,fixed',
            'value'       => 'required|numeric|min:1',
            'min_order'   => 'nullable|numeric|min:0',
            'max_discount'=> 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from'  => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active'   => 'boolean',
        ]);

        $coupon->update([
            'code'         => strtoupper($request->code),
            'description'  => $request->description,
            'type'         => $request->type,
            'value'        => $request->value,
            'min_order'    => $request->min_order ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit'  => $request->usage_limit,
            'valid_from'   => $request->valid_from,
            'valid_until'  => $request->valid_until,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil diperbarui.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil dihapus.');
    }
}
