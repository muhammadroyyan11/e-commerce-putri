@extends('layouts.app')

@section('title', __('messages.about.title', ['site' => App\Models\Setting::get('site_name', 'LongLeaf')]))
@section('meta_description', 'Kenali ' . App\Models\Setting::get('site_name', 'LongLeaf') . ' - Toko tanaman online terpercaya.')

@section('content')
<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 16px;">🌿 {{ __('messages.about.title', ['site' => App\Models\Setting::get('site_name', 'LongLeaf')]) }}</h1>
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; font-size: 14px;">
            <a href="/" style="color: rgba(255,255,255,0.8);">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.menu.about') }}</span>
        </div>
    </div>
</section>

<!-- Our Story -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <img src="{{ $about['hero_image'] }}"
                     alt="{{ App\Models\Setting::get('site_name', 'LongLeaf') }} Team"
                     style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);">
            </div>
            <div>
                <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">📖 {{ __('messages.about.story_tag') }}</span>
                <h2 style="font-size: 36px; font-weight: 700; color: #064e3b; margin-bottom: 20px; line-height: 1.2;">
                    {{ $about['story_title'] ?: __('messages.about.story_title') }}
                </h2>
                @if($about['story_desc1'])
                    <p style="color: #065f46; font-size: 16px; line-height: 1.8; margin-bottom: 20px;">{{ $about['story_desc1'] }}</p>
                @endif
                @if($about['story_desc2'])
                    <p style="color: #065f46; font-size: 16px; line-height: 1.8; margin-bottom: 30px;">{{ $about['story_desc2'] }}</p>
                @endif
                <div style="display: flex; gap: 40px;">
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">{{ $about['stat_years'] }}</div>
                        <div style="color: #065f46; font-size: 14px;">{{ __('messages.about.years') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">{{ $about['stat_plants'] }}</div>
                        <div style="color: #065f46; font-size: 14px;">{{ __('messages.about.plants_sold') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">{{ $about['stat_customers'] }}</div>
                        <div style="color: #065f46; font-size: 14px;">{{ __('messages.about.happy_customers') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.about.mission_vision') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.about.mission_vision_sub') }}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px;">🎯</div>
                <h3 style="font-size: 24px; font-weight: 700; color: #064e3b; margin-bottom: 16px;">{{ __('messages.about.mission') }}</h3>
                <p style="color: #065f46; line-height: 1.8;">{{ $about['mission'] ?: __('messages.about.mission_text') }}</p>
            </div>
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px;">👁️</div>
                <h3 style="font-size: 24px; font-weight: 700; color: #064e3b; margin-bottom: 16px;">{{ __('messages.about.vision') }}</h3>
                <p style="color: #065f46; line-height: 1.8;">{{ $about['vision'] ?: __('messages.about.vision_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
@if(collect($values)->filter(fn($v) => $v['title'])->count())
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.about.values') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.about.values_sub') }}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
            @foreach($values as $value)
            @if($value['title'])
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px;">{{ $value['icon'] }}</div>
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ $value['title'] }}</h4>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ $value['text'] }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team -->
@if($team->count())
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.about.team') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.about.team_sub', ['site' => App\Models\Setting::get('site_name', 'LongLeaf')]) }}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px;">
            @foreach($team as $member)
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1); text-align: center;">
                @if($member->photo)
                    <img src="{{ $member->photo }}" alt="{{ $member->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 200px; background: #d1fae5; display: flex; align-items: center; justify-content: center; font-size: 64px;">👤</div>
                @endif
                <div style="padding: 20px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #064e3b;">{{ $member->name }}</h4>
                    <p style="color: #10b981; font-size: 14px; margin-bottom: 0;">{{ $member->position }}</p>
                    @if($member->bio)
                        <p style="color: #065f46; font-size: 13px; margin-top: 8px; line-height: 1.5;">{{ $member->bio }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 30px; padding: 60px; text-align: center; color: white;">
            <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 16px;">
                {{ $about['cta_title'] ?: __('messages.about.cta_title') }}
            </h2>
            <p style="font-size: 18px; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                {{ $about['cta_desc'] ?: __('messages.about.cta_desc') }}
            </p>
            <a href="/shop" class="btn-primary" style="background: white; color: #059669; padding: 16px 40px; border-radius: 12px; font-weight: 600; display: inline-block;">
                {{ __('messages.button.shop_now') }}
            </a>
        </div>
    </div>
</section>
@endsection
