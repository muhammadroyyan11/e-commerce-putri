@extends('layouts.app')

@section('title', 'LongLeaf - Toko Tanaman Online')

@section('content')
<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(135deg, #064e3b 0%, #059669 50%, #10b981 100%); padding: 120px 0; color: white; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -100px; left: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(132,204,22,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="hero-grid">
            <div>
                <span style="display: inline-block; background: rgba(255,255,255,0.2); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 24px; backdrop-filter: blur(10px);">🌱 {{ __('messages.hero.tagline') }}</span>
                <h1 style="font-size: 56px; font-weight: 800; line-height: 1.1; margin-bottom: 24px;">{!! __('messages.hero.title') !!}</h1>
                <p style="font-size: 18px; opacity: 0.9; margin-bottom: 40px; line-height: 1.7;">{{ __('messages.hero.description') }}</p>
                <div style="display: flex; gap: 16px;">
                    <a href="{{ route('shop') }}" class="btn-primary" style="background: white; color: #059669; text-decoration: none;">{{ __('messages.button.shop_now') }}</a>
                    <a href="#kategori" class="btn-secondary" style="background: transparent; color: white; border-color: white; text-decoration: none;">{{ __('messages.button.view_categories') }}</a>
                </div>
                <div class="hero-stats" style="display: flex; gap: 40px; margin-top: 48px;">
                    <div>
                        <span style="font-size: 32px; font-weight: 800; color: #84cc16;">500+</span>
                        <p style="font-size: 14px; opacity: 0.8;">{{ __('messages.home.hero_stat_plants') }}</p>
                    </div>
                    <div>
                        <span style="font-size: 32px; font-weight: 800; color: #84cc16;">10K+</span>
                        <p style="font-size: 14px; opacity: 0.8;">{{ __('messages.home.hero_stat_customers') }}</p>
                    </div>
                    <div>
                        <span style="font-size: 32px; font-weight: 800; color: #84cc16;">100%</span>
                        <p style="font-size: 14px; opacity: 0.8;">{{ __('messages.home.hero_stat_healthy') }}</p>
                    </div>
                </div>
            </div>
            <div style="position: relative;">
                <img src="https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=600&h=700&fit=crop" alt="Tanaman Hias" style="width: 100%; height: 550px; object-fit: cover; border-radius: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3);">
                <div style="position: absolute; bottom: -20px; left: -30px; background: white; padding: 20px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 16px;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #84cc16); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div>
                        <p style="font-size: 14px; color: #6b7280; margin: 0;">{{ __('messages.home.hero_bestseller') }}</p>
                        <p style="font-size: 16px; font-weight: 700; color: #064e3b; margin: 0;">Monstera Deliciosa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Segments -->
<section class="benefits-section" id="kategori">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">{{ __('messages.category.title') }}</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px;">{{ __('messages.category.subtitle') }}</h2>
            <p style="color: var(--text-medium); max-width: 600px; margin: 0 auto;">{{ __('messages.category.description') }}</p>
        </div>
        
        <div class="category-segment">
            @foreach($categories as $category)
            <a href="{{ route('shop', ['category' => $category['slug']]) }}" class="segment-card" style="text-decoration: none;">
                <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
                <div class="segment-overlay">
                    <div class="segment-icon"><i class="fas {{ $category['icon'] }}"></i></div>
                    <h3 class="segment-name">{{ $category['name'] }}</h3>
                    <p class="segment-count">{{ __('messages.home.products_count', ['count' => $category['count']]) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <span style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">{{ __('messages.featured.promo') }}</span>
                <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark);">{{ __('messages.featured.title') }}</h2>
            </div>
            <a href="{{ route('shop') }}" style="display: flex; align-items: center; gap: 8px; color: var(--primary-color); font-weight: 600; text-decoration: none;">{{ __('messages.button.view_all') }} <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="products-grid featured-grid">
            @foreach($featuredProducts as $product)
            <div class="plant-card">
                <div class="plant-image">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                    @if($product['badge'])
                    <span class="plant-badge badge-{{ $product['badge'] }}">
                        @if($product['badge'] == 'sale') -{{ $product['discount'] }}%
                        @elseif($product['badge'] == 'new') {{ __('messages.home.hero_bestseller') === 'Terlaris' ? 'Baru' : 'New' }}
                        @elseif($product['badge'] == 'rare') {{ app()->getLocale()==='id' ? 'Langka' : 'Rare' }}
                        @else {{ ucfirst($product['badge']) }}
                        @endif
                    </span>
                    @endif
                    <div class="plant-overlay">
                        <div class="plant-actions">
                            <a href="{{ route('product.detail', $product['slug']) }}" class="plant-action-btn" title="{{ __('messages.shop.view_detail') }}"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                <button type="submit" class="plant-action-btn" title="{{ __('messages.button.add_to_cart') }}"><i class="fas fa-shopping-cart"></i></button>
                            </form>
                            @php $inWishlistHome = in_array($product['id'], $wishlistIds ?? []); @endphp
                            <button type="button" class="plant-action-btn btn-wishlist {{ $inWishlistHome ? 'active' : '' }}" data-product-id="{{ $product['id'] }}" title="{{ __('messages.shop.favorite') }}">
                                <i class="{{ $inWishlistHome ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="plant-info">
                    <span class="plant-category">{{ $product['category'] }}</span>
                    <h3 class="plant-name"><a href="{{ route('product.detail', $product['slug']) }}">{{ $product['name'] }}</a></h3>
                    <div class="plant-specs">
                        <span><i class="fas fa-ruler-vertical"></i> {{ $product['height'] }}</span>
                        <span><i class="fas fa-sun"></i> {{ $product['light'] }}</span>
                    </div>
                    <div class="care-icons">
                        <div class="care-icon" data-tooltip="{{ __('messages.shop.watering') }}: {{ pval($product['watering']) }}">💧</div>
                        <div class="care-icon" data-tooltip="{{ __('messages.shop.light') }}: {{ pval($product['light']) }}">🌤</div>
                        <div class="care-icon" data-tooltip="{{ pval($product['care_level']) }}">✨</div>
                    </div>
                    <div class="plant-price">
                        <span class="current">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        @if($product['original_price'])
                        <span class="original">Rp {{ number_format($product['original_price'], 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Care Guide Section -->
<section class="care-guide-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">{{ __('messages.home.care_tag') }}</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px;">{{ __('messages.home.care_title') }}</h2>
            <p style="color: var(--text-medium); max-width: 600px; margin: 0 auto;">{{ __('messages.home.care_subtitle') }}</p>
        </div>
        
        <div class="care-guide-grid">
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-tint"></i></div>
                <h4>{{ __('messages.home.care_watering_title') }}</h4>
                <p>{{ __('messages.home.care_watering_desc') }}</p>
                <div class="water-levels">
                    <div class="water-drop active"></div>
                    <div class="water-drop active"></div>
                    <div class="water-drop"></div>
                </div>
            </div>
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-sun"></i></div>
                <h4>{{ __('messages.home.care_light_title') }}</h4>
                <p>{{ __('messages.home.care_light_desc') }}</p>
                <div style="display: flex; gap: 8px; margin-top: 16px;">
                    <span style="padding: 4px 12px; background: white; border-radius: 20px; font-size: 12px; color: var(--primary-color);">🌤 {{ __('messages.care.indirect_light') }}</span>
                    <span style="padding: 4px 12px; background: white; border-radius: 20px; font-size: 12px; color: var(--secondary-color);">☀️ {{ __('messages.care.bright_light') }}</span>
                </div>
            </div>
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-wind"></i></div>
                <h4>{{ __('messages.home.care_air_title') }}</h4>
                <p>{{ __('messages.home.care_air_desc') }}</p>
                <p style="margin-top: 12px; font-size: 13px; color: var(--primary-color);"><i class="fas fa-check-circle"></i> {{ __('messages.home.care_air_tip') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Banner -->
<section class="seasonal-banner">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div class="seasonal-content">
            <span class="seasonal-tag">🌿 {{ __('messages.home.seasonal_tag') }}</span>
            <h2 class="seasonal-title">{{ __('messages.home.seasonal_title') }}</h2>
            <p class="seasonal-desc">{{ __('messages.home.seasonal_desc') }}</p>
            <a href="{{ route('category.outdoor') }}" class="btn-primary" style="display: inline-block; background: white; color: #059669; text-decoration: none;">{{ __('messages.home.seasonal_btn') }}</a>
        </div>
        <div class="seasonal-image">
            <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop" alt="Tanaman Outdoor">
        </div>
    </div>
</section>

<!-- Testimonials — F6: Real reviews from DB -->
<section class="testimonial-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: white; color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">
                {{ app()->getLocale()==='id' ? '⭐ Ulasan Pelanggan' : '⭐ Customer Reviews' }}
            </span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark);">
                {{ app()->getLocale()==='id' ? 'Apa Kata Pelanggan Kami' : 'What Our Customers Say' }}
            </h2>
        </div>

        <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            @foreach($testimonials->take(3) as $t)
            <div class="testimonial-card">
                {{-- Stars --}}
                <div style="display:flex;gap:3px;margin-bottom:14px;">
                    @for($s=1;$s<=5;$s++)
                    <i class="fas fa-star" style="font-size:14px;color:{{ $s<=$t['rating']?'#f59e0b':'#e5e7eb' }};"></i>
                    @endfor
                </div>
                <p class="testimonial-text" style="font-size:15px;line-height:1.7;color:#374151;margin-bottom:20px;">
                    "{{ $t['comment'] }}"
                </p>
                <div class="testimonial-author">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--gradient-primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:16px;flex-shrink:0;">
                        {{ $t['avatar'] }}
                    </div>
                    <div>
                        <h5 style="font-weight:700;color:#111827;margin:0;">{{ $t['name'] }}</h5>
                        @if(!empty($t['product_name']))
                        <span style="font-size:12px;color:#10b981;">🌿 {{ $t['product_name'] }}</span>
                        @endif
                    </div>
                    <span class="plant-lover-badge" style="margin-left:auto;"><i class="fas fa-leaf"></i> Verified</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- F7: Trust Badges -->
<section style="padding:48px 0;background:white;border-top:1px solid #f1f5f9;border-bottom:1px solid #f1f5f9;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
            @foreach($trustBadges as $badge)
            <div style="padding:24px 16px;">
                <div style="width:56px;height:56px;background:var(--primary-light);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:22px;color:{{ $badge['color'] }};">
                    <i class="fas {{ $badge['icon'] }}"></i>
                </div>
                <div style="font-size:28px;font-weight:900;color:{{ $badge['color'] }};line-height:1;">{{ $badge['value'] }}</div>
                <div style="font-size:13px;color:#6b7280;margin-top:4px;font-weight:500;">{{ $badge['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: white; color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">{{ __('messages.home.benefits_tag') }}</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark);">{{ __('messages.home.benefits_title', ['site' => App\Models\Setting::get('site_name','LongLeaf')]) }}</h2>
        </div>
        
        <div class="benefits-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
            @foreach($benefits as $benefit)
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas {{ $benefit['icon'] }}"></i></div>
                <h3>{{ $benefit['title'] }}</h3>
                <p>{{ $benefit['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h2>{{ __('messages.home.newsletter_title', ['site' => App\Models\Setting::get('site_name','LongLeaf')]) }}</h2>
            <p>{{ __('messages.home.newsletter_desc') }}</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form-green">
                @csrf
                <input type="email" name="email" placeholder="{{ __('messages.home.newsletter_placeholder') }}" required>
                <button type="submit">{{ __('messages.home.newsletter_btn') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection
