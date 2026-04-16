@extends('layouts.app')

@section('title', $product['name'] . ' - ' . App\Models\Setting::get('site_name', 'GreenHaven'))

@section('content')
<!-- Page Banner -->
<section class="page-banner blog-banner">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <a href="{{ route('shop') }}">{{ __('messages.product.detail_breadcrumb') }}</a>
            <span>/</span>
            <span>{{ $product['name'] }}</span>
        </nav>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-section" style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <div class="product-detail-layout">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="main-image" style="background: white; border-radius: 20px; overflow: hidden;">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" id="mainProductImage" style="width: 100%; height: 500px; object-fit: cover;">
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-section">
                <span class="product-category" style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $product['category'] }}</span>
                <h1 style="font-size: 32px; font-weight: 700; margin: 16px 0;">{{ $product['name'] }}</h1>
                
                <div class="product-price-section" style="padding: 20px 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); margin: 20px 0;">
                    <div class="price-wrapper" style="display: flex; align-items: center; gap: 16px;">
                        <span class="current-price" style="font-size: 32px; font-weight: 700; color: var(--primary-dark);">{{ $currency->format($product['price'], $currentCurrency) }}</span>
                        @if($product['original_price'])
                        <span class="original-price" style="font-size: 20px; color: var(--text-muted); text-decoration: line-through;">{{ $currency->format($product['original_price'], $currentCurrency) }}</span>
                        <span class="discount-badge" style="background: var(--error-color); color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">-{{ $product['discount'] }}%</span>
                        @endif
                    </div>
                </div>

                <div class="product-short-desc" style="color: var(--text-medium); line-height: 1.7; margin-bottom: 24px;">
                    <p>{{ $product['name'] }} {{ app()->getLocale() == 'id' ? 'adalah tanaman hias populer dengan perawatan' : 'is a popular ornamental plant with' }} {{ strtolower($product['care_level']) }}. {{ app()->getLocale() == 'id' ? 'Cocok untuk' : 'Suitable for' }} {{ strtolower($product['category']) }} {{ app()->getLocale() == 'id' ? 'dengan kebutuhan cahaya' : 'with light needs' }} {{ strtolower($product['light']) }}.</p>
                </div>

                <!-- Care Info -->
                <div style="background: var(--bg-light); padding: 20px; border-radius: 16px; margin-bottom: 24px;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                        <div style="text-align: center;">
                            <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 20px;">💧</div>
                            <span style="font-size: 12px; color: var(--text-muted); display: block;">{{ __('messages.shop.watering') }}</span>
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-dark);">{{ $product['watering'] }}</span>
                        </div>
                        <div style="text-align: center;">
                            <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 20px;">☀️</div>
                            <span style="font-size: 12px; color: var(--text-muted); display: block;">{{ __('messages.shop.light') }}</span>
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-dark);">{{ $product['light'] }}</span>
                        </div>
                        <div style="text-align: center;">
                            <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 20px;">📏</div>
                            <span style="font-size: 12px; color: var(--text-muted); display: block;">{{ __('messages.shop.height') }}</span>
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-dark);">{{ $product['height'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart -->
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <div class="option-row quantity-row" style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 12px; font-size: 14px;">{{ __('messages.product.quantity') }}</label>
                        <div class="quantity-cart-row" style="display: flex; gap: 12px;">
                            <div class="quantity-input detail" style="display: flex; border: 1px solid var(--border-color); border-radius: 12px;">
                                <button type="button" class="qty-btn minus" style="width: 48px; height: 52px; font-size: 18px; color: var(--text-medium);">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="10" id="productQty" style="width: 60px; text-align: center; border: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); font-weight: 600;">
                                <button type="button" class="qty-btn plus" style="width: 48px; height: 52px; font-size: 18px; color: var(--text-medium);">+</button>
                            </div>
                            <button type="submit" class="btn-add-cart-detail" style="flex: 1; height: 52px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; font-size: 16px; display: flex; align-items: center; justify-content: center; gap: 10px; border: none; cursor: pointer;">
                                <i class="fas fa-shopping-cart"></i> {{ __('messages.button.add_to_cart') }}
                            </button>
                            <button type="button" class="btn-wishlist-detail {{ $inWishlist ? 'active' : '' }}" data-product-id="{{ $product['id'] }}" style="width: 52px; height: 52px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 20px; color: var(--text-light); background: white; cursor: pointer;">
                                <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section style="padding: 60px 0; background: var(--bg-light);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h2 style="font-size: 28px; font-weight: 700;">{{ __('messages.product.similar_products') }}</h2>
                <p style="color: var(--text-light);">{{ __('messages.product.similar_desc') }}</p>
            </div>
            <a href="{{ route('shop') }}" style="display: flex; align-items: center; gap: 8px; color: var(--primary-color); font-weight: 600; text-decoration: none;">{{ __('messages.button.view_all') }} <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="products-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
            @foreach($relatedProducts as $related)
            <div class="plant-card">
                <div class="plant-image" style="height: 200px;">
                    <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}">
                    <div class="plant-overlay">
                        <div class="plant-actions">
                            <a href="{{ route('product.detail', $related['slug']) }}" class="plant-action-btn"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="plant-info">
                    <span class="plant-category">{{ $related['category'] }}</span>
                    <h3 class="plant-name"><a href="{{ route('product.detail', $related['slug']) }}">{{ $related['name'] }}</a></h3>
                    <div class="plant-specs">
                        <span><i class="fas fa-ruler-vertical"></i> {{ $related['height'] }}</span>
                        <span><i class="fas fa-sun"></i> {{ $related['light'] }}</span>
                    </div>
                    <div class="plant-price">
                        <span class="current">{{ $currency->format($related['price'], $currentCurrency) }}</span>
                        @if($related['original_price'])
                        <span class="original">{{ $currency->format($related['original_price'], $currentCurrency) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
