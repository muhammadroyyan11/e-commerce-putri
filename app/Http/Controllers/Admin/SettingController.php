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
            'site_name'       => Setting::get('site_name', 'LongLeaf'),
            'site_logo'       => Setting::get('site_logo', ''),
            // Contact
            'contact_address' => Setting::get('contact_address', ''),
            'contact_phone'   => Setting::get('contact_phone', ''),
            'contact_whatsapp'=> Setting::get('contact_whatsapp', ''),
            'contact_email'   => Setting::get('contact_email', ''),
            'contact_hours'   => Setting::get('contact_hours', ''),
            // Social media
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_instagram'=> Setting::get('social_instagram', ''),
            'social_twitter'  => Setting::get('social_twitter', ''),
            'social_youtube'  => Setting::get('social_youtube', ''),
            'social_tiktok'   => Setting::get('social_tiktok', ''),
            // Trust badges
            'trust_customers' => Setting::get('trust_customers', '10.000+'),
            'trust_products'  => Setting::get('trust_products', '500+'),
            'trust_delivery'  => Setting::get('trust_delivery', '100%'),
            'trust_rating'    => Setting::get('trust_rating', '4.9/5'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_logo'        => 'nullable|string|max:255',
            'site_logo_file'   => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'site_description' => 'nullable|string|max:500',
            'contact_address'  => 'nullable|string|max:500',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_email'    => 'nullable|email|max:255',
            'contact_hours'    => 'nullable|string|max:255',
            'social_facebook'  => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter'   => 'nullable|url|max:255',
            'social_youtube'   => 'nullable|url|max:255',
            'social_tiktok'    => 'nullable|url|max:255',
        ]);

        $keys = [
            'site_name', 'site_description',
            'contact_address','contact_phone','contact_whatsapp','contact_email','contact_hours',
            'social_facebook','social_instagram','social_twitter','social_youtube','social_tiktok',
            'trust_customers','trust_products','trust_delivery','trust_rating',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        if ($request->hasFile('site_logo_file')) {
            $path = public_path('uploads/settings');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $filename = 'logo_' . Str::uuid() . '.' . $request->file('site_logo_file')->getClientOriginalExtension();
            $request->file('site_logo_file')->move($path, $filename);
            Setting::set('site_logo', asset('uploads/settings/' . $filename));
        } elseif ($request->filled('site_logo')) {
            Setting::set('site_logo', $request->input('site_logo'));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
