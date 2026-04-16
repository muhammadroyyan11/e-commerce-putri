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
                        <p style="font-size: 14px; opacity: 0.8;">Jenis Tanaman</p>
                    </div>
                    <div>
                        <span style="font-size: 32px; font-weight: 800; color: #84cc16;">10K+</span>
                        <p style="font-size: 14px; opacity: 0.8;">Pelanggan Puas</p>
                    </div>
                    <div>
                        <span style="font-size: 32px; font-weight: 800; color: #84cc16;">100%</span>
                        <p style="font-size: 14px; opacity: 0.8;">Tanaman Sehat</p>
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
                        <p style="font-size: 14px; color: #6b7280; margin: 0;">Tanaman Terlaris</p>
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
                    <p class="segment-count">{{ $category['count'] }}+ Produk</p>
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
                        @elseif($product['badge'] == 'new') Baru
                        @elseif($product['badge'] == 'rare') Langka
                        @else {{ ucfirst($product['badge']) }}
                        @endif
                    </span>
                    @endif
                    <div class="plant-overlay">
                        <div class="plant-actions">
                            <a href="{{ route('product.detail', $product['slug']) }}" class="plant-action-btn" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                <button type="submit" class="plant-action-btn" title="Tambah ke Keranjang"><i class="fas fa-shopping-cart"></i></button>
                            </form>
                            @php $inWishlistHome = in_array($product['id'], $wishlistIds ?? []); @endphp
                            <button type="button" class="plant-action-btn btn-wishlist {{ $inWishlistHome ? 'active' : '' }}" data-product-id="{{ $product['id'] }}" title="Favorit">
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
                        <div class="care-icon" data-tooltip="Penyiraman {{ $product['watering'] }}">💧</div>
                        <div class="care-icon" data-tooltip="Cahaya {{ $product['light'] }}">🌤</div>
                        <div class="care-icon" data-tooltip="{{ $product['care_level'] }}">✨</div>
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
            <span style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">Panduan Perawatan</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px;">Tips Merawat Tanaman</h2>
            <p style="color: var(--text-medium); max-width: 600px; margin: 0 auto;">Ikuti panduan sederhana ini untuk menjaga tanaman Anda tetap sehat dan subur</p>
        </div>
        
        <div class="care-guide-grid">
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-tint"></i></div>
                <h4>Penyiraman Tepat</h4>
                <p>Siram tanaman saat media tanam mulai kering. Hindari menyiram terlalu sering yang dapat menyebabkan akar membusuk.</p>
                <div class="water-levels">
                    <div class="water-drop active"></div>
                    <div class="water-drop active"></div>
                    <div class="water-drop"></div>
                </div>
            </div>
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-sun"></i></div>
                <h4>Cahaya yang Sesuai</h4>
                <p>Setiap tanaman membutuhkan cahaya berbeda. Pahami kebutuhan cahaya tanaman Anda untuk pertumbuhan optimal.</p>
                <div style="display: flex; gap: 8px; margin-top: 16px;">
                    <span style="padding: 4px 12px; background: white; border-radius: 20px; font-size: 12px; color: var(--primary-color);">🌤 Teduh</span>
                    <span style="padding: 4px 12px; background: white; border-radius: 20px; font-size: 12px; color: var(--secondary-color);">☀️ Cerah</span>
                </div>
            </div>
            <div class="care-guide-card">
                <div class="care-guide-icon"><i class="fas fa-wind"></i></div>
                <h4>Sirkulasi Udara</h4>
                <p>Pastikan ruangan memiliki sirkulasi udara yang baik. Hindari menempatkan tanaman di dekat AC atau heater.</p>
                <p style="margin-top: 12px; font-size: 13px; color: var(--primary-color);"><i class="fas fa-check-circle"></i> Udara segar = Tanaman sehat</p>
            </div>
        </div>
    </div>
</section>

<!-- Seasonal Banner -->
<section class="seasonal-banner">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div class="seasonal-content">
            <span class="seasonal-tag">🌿 Promo Musiman</span>
            <h2 class="seasonal-title">Diskon 30% untuk Tanaman Outdoor!</h2>
            <p class="seasonal-desc">Persiapkan taman Anda untuk musim panas dengan koleksi tanaman outdoor terbaik kami. Penawaran terbatas!</p>
            <a href="{{ route('category.outdoor') }}" class="btn-primary" style="display: inline-block; background: white; color: #059669; text-decoration: none;">Lihat Koleksi</a>
        </div>
        <div class="seasonal-image">
            <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop" alt="Tanaman Outdoor">
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonial-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: white; color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">Testimonial</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark);">Apa Kata Pecinta Tanaman</h2>
        </div>
        
        <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <p class="testimonial-text">"{{ $testimonial['comment'] }}"</p>
                <div class="testimonial-author">
                    <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <h5>{{ $testimonial['name'] }}</h5>
                        <span>{{ $testimonial['location'] }}</span>
                    </div>
                    <span class="plant-lover-badge"><i class="fas fa-leaf"></i> Plant Lover</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <span style="display: inline-block; background: white; color: var(--primary-dark); padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 16px;">Keuntungan</span>
            <h2 style="font-size: 36px; font-weight: 800; color: var(--text-dark);">Mengapa Memilih LongLeaf?</h2>
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
            <h2>Bergabung dengan Komunitas LongLeaf</h2>
            <p>Dapatkan tips perawatan tanaman, promo eksklusif, dan update koleksi terbaru langsung di inbox Anda.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form-green">
                @csrf
                <input type="email" name="email" placeholder="Masukkan email Anda" required>
                <button type="submit">Berlangganan</button>
            </form>
        </div>
    </div>
</section>
@endsection
