<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $s = fn($key, $default = '') => Setting::get($key, $default);
        $lang = app()->getLocale();

        $about = [
            'hero_image'     => $s('about_hero_image', 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop'),
            'story_title'    => $s("about_story_title_{$lang}", $s('about_story_title_id')),
            'story_desc1'    => $s("about_story_desc1_{$lang}", $s('about_story_desc1_id')),
            'story_desc2'    => $s("about_story_desc2_{$lang}", $s('about_story_desc2_id')),
            'stat_years'     => $s('about_stat_years', '4+'),
            'stat_plants'    => $s('about_stat_plants', '50K+'),
            'stat_customers' => $s('about_stat_customers', '10K+'),
            'mission'        => $s("about_mission_{$lang}", $s('about_mission_id')),
            'vision'         => $s("about_vision_{$lang}", $s('about_vision_id')),
            'cta_title'      => $s("about_cta_title_{$lang}", $s('about_cta_title_id')),
            'cta_desc'       => $s("about_cta_desc_{$lang}", $s('about_cta_desc_id')),
        ];

        // Values (4 items)
        $values = [];
        for ($i = 1; $i <= 4; $i++) {
            $values[] = [
                'icon'  => $s("about_value{$i}_icon", ['🌱','💚','📚','🤝'][$i-1]),
                'title' => $s("about_value{$i}_title_{$lang}", $s("about_value{$i}_title_id")),
                'text'  => $s("about_value{$i}_text_{$lang}", $s("about_value{$i}_text_id")),
            ];
        }

        $team = TeamMember::active()->get();

        return view('pages.about', compact('about', 'values', 'team'));
    }
}
