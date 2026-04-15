<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'GreenHaven'),
            'site_logo' => Setting::get('site_logo', ''),
            'payment_methods' => Setting::get('payment_methods', "Transfer Bank BCA\nTransfer Bank Mandiri\nCOD (Bayar di Tempat)"),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|string|max:255',
            'site_logo_file' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'payment_methods' => 'nullable|string',
        ]);

        Setting::set('site_name', $validated['site_name']);
        Setting::set('payment_methods', $validated['payment_methods'] ?? '');

        if ($request->hasFile('site_logo_file')) {
            $path = public_path('uploads/settings');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $filename = 'logo_' . Str::uuid() . '.' . $request->file('site_logo_file')->getClientOriginalExtension();
            $request->file('site_logo_file')->move($path, $filename);
            Setting::set('site_logo', asset('uploads/settings/' . $filename));
        } elseif ($request->filled('site_logo')) {
            Setting::set('site_logo', $validated['site_logo']);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
