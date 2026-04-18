<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AboutSettingController extends Controller
{
    private array $keys = [
        'about_hero_image',
        'about_story_title_id', 'about_story_title_en',
        'about_story_desc1_id', 'about_story_desc1_en',
        'about_story_desc2_id', 'about_story_desc2_en',
        'about_stat_years', 'about_stat_plants', 'about_stat_customers',
        'about_mission_id', 'about_mission_en',
        'about_vision_id', 'about_vision_en',
        'about_value1_title_id', 'about_value1_title_en', 'about_value1_text_id', 'about_value1_text_en', 'about_value1_icon',
        'about_value2_title_id', 'about_value2_title_en', 'about_value2_text_id', 'about_value2_text_en', 'about_value2_icon',
        'about_value3_title_id', 'about_value3_title_en', 'about_value3_text_id', 'about_value3_text_en', 'about_value3_icon',
        'about_value4_title_id', 'about_value4_title_en', 'about_value4_text_id', 'about_value4_text_en', 'about_value4_icon',
        'about_cta_title_id', 'about_cta_title_en',
        'about_cta_desc_id', 'about_cta_desc_en',
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }
        return view('admin.about.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($this->keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        // Handle hero image upload
        if ($request->hasFile('about_hero_image_file')) {
            $path = public_path('uploads/about');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $filename = 'hero_' . time() . '.' . $request->file('about_hero_image_file')->getClientOriginalExtension();
            $request->file('about_hero_image_file')->move($path, $filename);
            Setting::set('about_hero_image', asset('uploads/about/' . $filename));
        }

        return redirect()->route('admin.about.index')->with('success', 'Pengaturan halaman About berhasil disimpan.');
    }
}
