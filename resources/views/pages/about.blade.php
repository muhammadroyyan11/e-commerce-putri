@extends('layouts.app')

@section('title', __('messages.about.title', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]))
@section('meta_description', 'Kenali ' . App\Models\Setting::get('site_name', 'GreenHaven') . ' - Toko tanaman online terpercaya dengan komitmen menghadirkan tanaman berkualitas dan edukasi perawatan.')

@section('content')
<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 16px;">🌿 {{ __('messages.about.title', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}</h1>
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
                <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop" 
                     alt="GreenHaven Team" 
                     style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);">
            </div>
            <div>
                <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">📖 {{ __('messages.about.story_tag') }}</span>
                <h2 style="font-size: 36px; font-weight: 700; color: #064e3b; margin-bottom: 20px; line-height: 1.2;">{{ __('messages.about.story_title') }}</h2>
                <p style="color: #065f46; font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                    {{ __('messages.about.story_desc', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}
                </p>
                <p style="color: #065f46; font-size: 16px; line-height: 1.8; margin-bottom: 30px;">
                    {{ __('messages.about.story_desc2', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}
                </p>
                <div style="display: flex; gap: 40px;">
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">4+</div>
                        <div style="color: #065f46; font-size: 14px;">{{ __('messages.about.years') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">50K+</div>
                        <div style="color: #065f46; font-size: 14px;">{{ __('messages.about.plants_sold') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 36px; font-weight: 700; color: #10b981;">10K+</div>
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
                <p style="color: #065f46; line-height: 1.8;">
                    {{ __('messages.about.mission_text') }}
                </p>
            </div>
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px;">👁️</div>
                <h3 style="font-size: 24px; font-weight: 700; color: #064e3b; margin-bottom: 16px;">{{ __('messages.about.vision') }}</h3>
                <p style="color: #065f46; line-height: 1.8;">
                    {{ __('messages.about.vision_text') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.about.values') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.about.values_sub') }}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px;">🌱</div>
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.about.quality') }}</h4>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.about.quality_text') }}</p>
            </div>
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px;">💚</div>
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.about.sustainability') }}</h4>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.about.sustainability_text') }}</p>
            </div>
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px;">📚</div>
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.about.education') }}</h4>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.about.education_text') }}</p>
            </div>
            <div style="text-align: center; padding: 30px;">
                <div style="width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px;">🤝</div>
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.about.community') }}</h4>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.about.community_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.about.team') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.about.team_sub', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px;">
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1); text-align: center;">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face" 
                     alt="Andi Wijaya" 
                     style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #064e3b;">Andi Wijaya</h4>
                    <p style="color: #10b981; font-size: 14px;">Founder & CEO</p>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1); text-align: center;">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop&crop=face" 
                     alt="Sari Melati" 
                     style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #064e3b;">Sari Melati</h4>
                    <p style="color: #10b981; font-size: 14px;">Head of Horticulture</p>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1); text-align: center;">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face" 
                     alt="Budi Santoso" 
                     style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #064e3b;">Budi Santoso</h4>
                    <p style="color: #10b981; font-size: 14px;">Operations Manager</p>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1); text-align: center;">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop&crop=face" 
                     alt="Rina Dewi" 
                     style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #064e3b;">Rina Dewi</h4>
                    <p style="color: #10b981; font-size: 14px;">Customer Success</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 30px; padding: 60px; text-align: center; color: white;">
            <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 16px;">{{ __('messages.about.cta_title') }}</h2>
            <p style="font-size: 18px; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">{{ __('messages.about.cta_desc') }}</p>
            <a href="/shop" class="btn-primary" style="background: white; color: #059669; padding: 16px 40px; border-radius: 12px; font-weight: 600; display: inline-block;">
                {{ __('messages.button.shop_now') }}
            </a>
        </div>
    </div>
</section>
@endsection
