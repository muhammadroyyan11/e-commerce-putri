@extends('layouts.app')

@section('title', __('messages.care.title') . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>🌱 {{ __('messages.care.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.care.title') }}</span>
        </nav>
    </div>
</section>

<!-- Quick Care Cards -->
<section style="padding: 60px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 32px; font-weight: 700; color: #064e3b;">{{ __('messages.care.basics') }}</h2>
            <p style="color: #065f46; margin-top: 12px;">{{ __('messages.care.basics_sub') }}</p>
        </div>
        <div class="cg-grid-4">
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">💧</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __('messages.care.watering') }}</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.care.watering_text') }}</p>
            </div>
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">☀️</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __('messages.care.lighting') }}</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.care.lighting_text') }}</p>
            </div>
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">🌡️</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __('messages.care.temp_humidity') }}</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.care.temp_humidity_text') }}</p>
            </div>
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">🧪</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __('messages.care.fertilizing') }}</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">{{ __('messages.care.fertilizing_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Watering Guide -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div class="cg-grid-2col">
            <div>
                <span style="display: inline-block; background: #dbeafe; color: #1e40af; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">💧 {{ __('messages.care.watering_guide') }}</span>
                <h2 style="font-size: 36px; font-weight: 700; color: #064e3b; margin-bottom: 20px;">{{ __('messages.care.watering_title') }}</h2>
                <p style="color: #065f46; line-height: 1.8; margin-bottom: 24px;">{{ __('messages.care.watering_desc') }}</p>
                <div>
                    @foreach([
                        ['messages.care.check_soil',  'messages.care.check_soil_text'],
                        ['messages.care.soak_well',   'messages.care.soak_well_text'],
                        ['messages.care.drain_excess','messages.care.drain_excess_text'],
                        ['messages.care.room_temp',   'messages.care.room_temp_text'],
                    ] as $i => [$title, $desc])
                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; flex-shrink: 0;">{{ $i+1 }}</div>
                        <div>
                            <h4 style="font-weight: 600; color: #064e3b; margin-bottom: 4px;">{{ __($title) }}</h4>
                            <p style="color: #065f46; font-size: 14px;">{{ __($desc) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=600&h=500&fit=crop"
                     alt="{{ __('messages.care.watering_guide') }}"
                     style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);">
            </div>
        </div>
    </div>
</section>

<!-- Light Guide -->
<section style="padding: 80px 0; background: #fefce8;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.care.light_guide') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.care.light_guide_sub') }}</p>
        </div>
        <div class="cg-grid-3">
            @foreach([
                ['☀️', 'messages.care.bright_light',   'messages.care.bright_light_text',   'Kaktus, Sukulen, Monstera, Fiddle Leaf Fig', 'messages.care.location'],
                ['🌤️','messages.care.indirect_light', 'messages.care.indirect_light_text', 'Pothos, Philodendron, Peace Lily, Spider Plant', 'messages.care.location'],
                ['🌥️','messages.care.low_light',      'messages.care.low_light_text',      'Snake Plant, ZZ Plant, Cast Iron Plant, Pothos', 'messages.care.location'],
            ] as [$icon, $title, $desc, $examples, $loc])
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 48px; margin-bottom: 20px;">{{ $icon }}</div>
                <h3 style="font-size: 20px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __($title) }}</h3>
                <p style="color: #065f46; margin-bottom: 16px; font-size: 14px;">{{ __($desc) }}</p>
                <div style="background: #fef3c7; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">
                    <strong style="color: #92400e; font-size: 13px;">{{ __('messages.care.examples') }}:</strong>
                    <p style="color: #a16207; font-size: 13px; margin-top: 4px;">{{ $examples }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Common Problems -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.care.problems') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.care.problems_sub') }}</p>
        </div>
        <div class="cg-grid-2">
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #991b1b; margin-bottom: 12px;">🍂 {{ __('messages.care.yellow_leaves') }}</h4>
                <p style="color: #7f1d1d; margin-bottom: 8px;"><strong>{{ __('messages.care.yellow_leaves_cause') }}</strong> {{ __('messages.care.yellow_leaves_cause_text') }}</p>
                <p style="color: #7f1d1d;"><strong>{{ __('messages.care.yellow_leaves_solution') }}</strong> {{ __('messages.care.yellow_leaves_solution_text') }}</p>
            </div>
            <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #92400e; margin-bottom: 12px;">🥀 {{ __('messages.care.wilting') }}</h4>
                <p style="color: #78350f; margin-bottom: 8px;"><strong>{{ __('messages.care.yellow_leaves_cause') }}</strong> {{ __('messages.care.wilting_cause_text') }}</p>
                <p style="color: #78350f;"><strong>{{ __('messages.care.yellow_leaves_solution') }}</strong> {{ __('messages.care.wilting_solution_text') }}</p>
            </div>
            <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #1e40af; margin-bottom: 12px;">🐛 {{ __('messages.care.pests') }}</h4>
                <p style="color: #1e3a8a; margin-bottom: 8px;"><strong>{{ __('messages.care.yellow_leaves_cause') }}</strong> {{ __('messages.care.pests_cause_text') }}</p>
                <p style="color: #1e3a8a;"><strong>{{ __('messages.care.yellow_leaves_solution') }}</strong> {{ __('messages.care.pests_solution_text') }}</p>
            </div>
            <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #065f46; margin-bottom: 12px;">🌱 {{ __('messages.care.slow_growth') }}</h4>
                <p style="color: #064e3b; margin-bottom: 8px;"><strong>{{ __('messages.care.yellow_leaves_cause') }}</strong> {{ __('messages.care.slow_growth_cause_text') }}</p>
                <p style="color: #064e3b;"><strong>{{ __('messages.care.yellow_leaves_solution') }}</strong> {{ __('messages.care.slow_growth_solution_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Care -->
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.care.seasonal') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.care.seasonal_sub') }}</p>
        </div>
        <div class="cg-grid-4">
            @foreach([
                ['🌸', 'messages.care.spring', 'messages.care.spring_tips'],
                ['☀️', 'messages.care.summer', 'messages.care.summer_tips'],
                ['🍂', 'messages.care.autumn', 'messages.care.autumn_tips'],
                ['❄️', 'messages.care.winter', 'messages.care.winter_tips'],
            ] as [$icon, $season, $tips])
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="font-size: 40px; margin-bottom: 16px;">{{ $icon }}</div>
                <h4 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">{{ __($season) }}</h4>
                <ul style="color: #065f46; font-size: 14px; text-align: left; padding-left: 20px;">{!! __($tips) !!}</ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 30px; padding: 60px; text-align: center; color: white;">
            <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 16px;">{{ __('messages.care.cta_title') }}</h2>
            <p style="font-size: 16px; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">{{ __('messages.care.cta_desc') }}</p>
            <div style="display: flex; gap: 16px; justify-content: center;">
                <a href="{{ route('contact') }}" style="background: white; color: #059669; padding: 16px 32px; border-radius: 12px; font-weight: 600; text-decoration: none;">
                    {{ __('messages.faq.contact_us') }}
                </a>
                <a href="{{ route('shop') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 16px 32px; border-radius: 12px; font-weight: 600; border: 2px solid white; text-decoration: none;">
                    {{ __('messages.button.shop_now') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 16px;">🌱 Panduan Perawatan</h1>
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; font-size: 14px;">
            <a href="/" style="color: rgba(255,255,255,0.8);">Beranda</a>
            <span>/</span>
            <span>Panduan Perawatan</span>
        </div>
    </div>
</section>

<!-- Quick Care Cards -->
<section style="padding: 60px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 32px; font-weight: 700; color: #064e3b;">Dasar Perawatan Tanaman</h2>
            <p style="color: #065f46; margin-top: 12px;">Empat pilar utama untuk tanaman yang sehat dan subur</p>
        </div>
        
        <div class="cg-grid-4">
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">💧</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Penyiraman</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">Jangan terlalu sering! Periksa kelembaban tanah 2-3 cm dari permukaan.</p>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">☀️</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Pencahayaan</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">Kenali kebutuhan cahaya tanaman Anda - terang, teduh, atau rendah.</p>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">🌡️</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Suhu & Kelembaban</h3>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">Kebanyakan tanaman suka suhu 18-24°C dengan kelembaban 40-60%.</p>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">🧪</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Pemupukan</div>
                <p style="color: #065f46; font-size: 14px; line-height: 1.6;">Pupuk setiap 2-4 minggu saat musim tumbuh (spring/summer).</p>
            </div>
        </div>
    </div>
</section>

<!-- Watering Guide -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div class="cg-grid-2col">
            <div>
                <span style="display: inline-block; background: #dbeafe; color: #1e40af; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">💧 Panduan Penyiraman</span>
                <h2 style="font-size: 36px; font-weight: 700; color: #064e3b; margin-bottom: 20px;">Kapan dan Bagaimana Menyiram</h2>
                <p style="color: #065f46; line-height: 1.8; margin-bottom: 24px;">
                    Penyiraman yang benar adalah kunci tanaman yang sehat. Kebanyakan pemula melakukan kesalahan dengan menyiram terlalu sering.
                </p>
                
                <div style="space-y: 16px;">
                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; flex-shrink: 0;">1</div>
                        <div>
                            <h4 style="font-weight: 600; color: #064e3b; margin-bottom: 4px;">Periksa Kelembaban Tanah</h4>
                            <p style="color: #065f46; font-size: 14px;">Masukkan jari 2-3 cm ke tanah. Jika kering, saatnya menyiram.</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; flex-shrink: 0;">2</div>
                        <div>
                            <h4 style="font-weight: 600; color: #064e3b; margin-bottom: 4px;">Siram Hingga Meresap</h4>
                            <p style="color: #065f46; font-size: 14px;">Siram perlahan hingga air keluar dari lubang drainase.</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; flex-shrink: 0;">3</div>
                        <div>
                            <h4 style="font-weight: 600; color: #064e3b; margin-bottom: 4px;">Buang Air yang Tersisa</h4>
                            <p style="color: #065f46; font-size: 14px;">Jangan biarkan tanaman berdiri di air - ini bisa menyebabkan akar busuk.</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 16px;">
                        <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; flex-shrink: 0;">4</div>
                        <div>
                            <h4 style="font-weight: 600; color: #064e3b; margin-bottom: 4px;">Gunakan Air Suhu Ruang</h4>
                            <p style="color: #065f46; font-size: 14px;">Air dingin bisa menyokok akar. Diamkan air semalaman untuk menghilangkan klorin.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=600&h=500&fit=crop" 
                     alt="Watering Plants" 
                     style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);">
            </div>
        </div>
    </div>
</section>

<!-- Light Guide -->
<section style="padding: 80px 0; background: #fefce8;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">Panduan Pencahayaan</h2>
            <p style="color: #065f46; margin-top: 16px;">Pahami kebutuhan cahaya tanaman Anda</p>
        </div>
        
        <div class="cg-grid-3">
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 48px; margin-bottom: 20px;">☀️</div>
                <h3 style="font-size: 20px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Cahaya Terang (Bright Light)</h3>
                <p style="color: #065f46; margin-bottom: 16px; font-size: 14px;">Cahaya matahari langsung atau dekat jendela selatan.</p>
                <div style="background: #fef3c7; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">
                    <strong style="color: #92400e; font-size: 13px;">Contoh Tanaman:</strong>
                    <p style="color: #a16207; font-size: 13px; margin-top: 4px;">Kaktus, Sukulen, Monstera, Fiddle Leaf Fig</p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: #059669; font-size: 14px;">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Dekat jendela selatan/timur</span>
                </div>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 48px; margin-bottom: 20px;">🌤️</div>
                <h3 style="font-size: 20px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Cahaya Teduh (Indirect Light)</h3>
                <p style="color: #065f46; margin-bottom: 16px; font-size: 14px;">Cahaya terang tapi tidak langsung, bayangan lembut.</p>
                <div style="background: #fef3c7; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">
                    <strong style="color: #92400e; font-size: 13px;">Contoh Tanaman:</strong>
                    <p style="color: #a16207; font-size: 13px; margin-top: 4px;">Pothos, Philodendron, Peace Lily, Spider Plant</p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: #059669; font-size: 14px;">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>1-2 meter dari jendela</span>
                </div>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 48px; margin-bottom: 20px;">🌥️</div>
                <h3 style="font-size: 20px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Cahaya Rendah (Low Light)</h3>
                <p style="color: #065f46; margin-bottom: 16px; font-size: 14px;">Jauh dari jendela atau ruangan dengan sedikit cahaya alami.</p>
                <div style="background: #fef3c7; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">
                    <strong style="color: #92400e; font-size: 13px;">Contoh Tanaman:</strong>
                    <p style="color: #a16207; font-size: 13px; margin-top: 4px;">Snake Plant, ZZ Plant, Cast Iron Plant, Pothos</p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: #059669; font-size: 14px;">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Ruang dalam, lorong</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Common Problems -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">Masalah Umum & Solusi</h2>
            <p style="color: #065f46; margin-top: 16px;">Kenali tanda-tanda tanaman tidak sehat</p>
        </div>
        
        <div class="cg-grid-2">
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #991b1b; margin-bottom: 12px;">🍂 Daun Menguning</h4>
                <p style="color: #7f1d1d; margin-bottom: 8px;"><strong>Penyebab:</strong> Penyiraman berlebihan, kekurangan nutrisi, atau cahaya tidak cukup.</p>
                <p style="color: #7f1d1d;"><strong>Solusi:</strong> Periksa kelembaban tanah, kurangi frekuensi menyiram, pindahkan ke lokasi dengan cahaya lebih baik.</p>
            </div>
            
            <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #92400e; margin-bottom: 12px;">🥀 Daun Layu</h4>
                <p style="color: #78350f; margin-bottom: 8px;"><strong>Penyebab:</strong> Kekurangan air, akar busuk, atau tanaman terlalu panas.</p>
                <p style="color: #78350f;"><strong>Solusi:</strong> Siram segera jika tanah kering, periksa akar untuk busuk, pindahkan dari sumber panas.</p>
            </div>
            
            <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #1e40af; margin-bottom: 12px;">🐛 Hama (Kutu, Semut)</h4>
                <p style="color: #1e3a8a; margin-bottom: 8px;"><strong>Penyebab:</strong> Kelembaban tinggi, tanaman stres, atau datang dari tanaman lain.</p>
                <p style="color: #1e3a8a;"><strong>Solusi:</strong> Lap daun dengan sabun cuci piring encer, semprot neem oil, isolasi tanaman yang terinfeksi.</p>
            </div>
            
            <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 24px; border-radius: 0 12px 12px 0;">
                <h4 style="font-size: 18px; font-weight: 700; color: #065f46; margin-bottom: 12px;">🌱 Pertumbuhan Lambat</h4>
                <p style="color: #064e3b; margin-bottom: 8px;"><strong>Penyebab:</strong> Musim dorman (normal), pot terlalu kecil, atau kurang nutrisi.</p>
                <p style="color: #064e3b;"><strong>Solusi:</strong> Tunggu musim semi, repot ke pot lebih besar, beri pupuk NPK seimbang.</p>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Care -->
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">Perawatan Musiman</h2>
            <p style="color: #065f46; margin-top: 16px;">Sesuaikan perawatan dengan musim</p>
        </div>
        
        <div class="cg-grid-4">
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="font-size: 40px; margin-bottom: 16px;">🌸</div>
                <h4 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Musim Semi</h4>
                <ul style="color: #065f46; font-size: 14px; text-align: left; padding-left: 20px;">
                    <li>Waktu terbaik untuk repot</li>
                    <li>Mulai pupuk rutin</li>
                    <li>Perbanyak penyiraman</li>
                    <li>Potong bagian mati</li>
                </ul>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="font-size: 40px; margin-bottom: 16px;">☀️</div>
                <h4 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Musim Panas</h4>
                <ul style="color: #065f46; font-size: 14px; text-align: left; padding-left: 20px;">
                    <li>Siram lebih sering</li>
                    <li>Semprot kelembaban</li>
                    <li> Hindari sinar terik</li>
                    <li>Pantau hama</li>
                </ul>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="font-size: 40px; margin-bottom: 16px;">🍂</div>
                <h4 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Musim Gugur</h4>
                <ul style="color: #065f46; font-size: 14px; text-align: left; padding-left: 20px;">
                    <li>Kurangi frekuensi pupuk</li>
                    <li>Siram lebih sedikit</li>
                    <li>Pindahkan ke cahaya lebih terang</li>
                    <li>Bersihkan daun kering</li>
                </ul>
            </div>
            
            <div style="background: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);">
                <div style="font-size: 40px; margin-bottom: 16px;">❄️</div>
                <h4 style="font-size: 18px; font-weight: 700; color: #064e3b; margin-bottom: 12px;">Musim Dingin</h4>
                <ul style="color: #065f46; font-size: 14px; text-align: left; padding-left: 20px;">
                    <li>Henti pemupukan</li>
                    <li>Kurangi penyiraman</li>
                    <li>Jauhkan dari heater</li>
                    <li>Tingkatkan kelembaban</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 30px; padding: 60px; text-align: center; color: white;">
            <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 16px;">Masih Punya Pertanyaan?</h2>
            <p style="font-size: 16px; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">Tim ahli kami siap membantu Anda dengan tips perawatan personal untuk tanaman Anda.</p>
            <div style="display: flex; gap: 16px; justify-content: center;">
                <a href="/contact" style="background: white; color: #059669; padding: 16px 32px; border-radius: 12px; font-weight: 600;">
                    Hubungi Kami
                </a>
                <a href="/shop" style="background: rgba(255,255,255,0.2); color: white; padding: 16px 32px; border-radius: 12px; font-weight: 600; border: 2px solid white;">
                    Belanja Tanaman
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
