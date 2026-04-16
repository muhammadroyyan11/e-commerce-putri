@extends('layouts.app')

@section('title', (isset($pageTitle) ? $pageTitle : __('messages.shop.title')) . ' - ' . App\Models\Setting::get('site_name', 'GreenHaven'))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>{{ isset($pageTitle) ? $pageTitle : __('messages.shop.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.shop.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<!-- Shop Section -->
<section class="shop-section" style="padding: 60px 0; background: var(--bg-light);">
    <div class="container">
        <div class="shop-layout">
            <!-- Sidebar Filters -->
            <aside class="shop-sidebar">
                <!-- Categories -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-seedling" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.shop.categories') }}</h3>
                    <ul class="shop-category-list">
                        <li><a href="{{ route('shop') }}" class="{{ !request('category') ? 'active' : '' }}"><span>{{ __('messages.shop.all_plants') }}</span><span class="count">{{ $categories->sum('count') }}</span></a></li>
                        <li><a href="{{ route('category.indoor') }}" class="{{ request('category') == 'indoor' ? 'active' : '' }}"><span>🌿 {{ __('messages.shop.indoor') }}</span><span class="count">{{ $categories->firstWhere('slug', 'indoor')?->count ?? 0 }}</span></a></li>
                        <li><a href="{{ route('category.outdoor') }}" class="{{ request('category') == 'outdoor' ? 'active' : '' }}"><span>☀️ {{ __('messages.shop.outdoor') }}</span><span class="count">{{ $categories->firstWhere('slug', 'outdoor')?->count ?? 0 }}</span></a></li>
                        <li><a href="{{ route('category.succulent') }}" class="{{ request('category') == 'succulent' ? 'active' : '' }}"><span>🌵 {{ __('messages.shop.succulent') }}</span><span class="count">{{ $categories->firstWhere('slug', 'succulent')?->count ?? 0 }}</span></a></li>
                        <li><a href="{{ route('category.rare') }}" class="{{ request('category') == 'rare' ? 'active' : '' }}"><span>💎 {{ __('messages.shop.rare') }}</span><span class="count">{{ $categories->firstWhere('slug', 'rare')?->count ?? 0 }}</span></a></li>
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-tag" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.shop.price_range') }}</h3>
                    <div class="price-range-slider">
                        <div class="price-inputs">
                            <div class="price-field">
                                <span>Rp</span>
                                <input type="number" value="0" min="0" id="minPrice">
                            </div>
                            <span class="separator">-</span>
                            <div class="price-field">
                                <span>Rp</span>
                                <input type="number" value="500000" min="0" id="maxPrice">
                            </div>
                        </div>
                        <button class="btn-filter-price">{{ __('messages.shop.filter') }}</button>
                    </div>
                </div>

                <!-- Care Level Filter -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-hand-holding-heart" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.shop.care_level') }}</h3>
                    <ul class="brand-list">
                        <li><label class="checkbox-label"><input type="checkbox"><span class="checkmark"></span><span class="label-text">⭐ {{ __('messages.shop.very_easy') }}</span><span class="count">(45)</span></label></li>
                        <li><label class="checkbox-label"><input type="checkbox" checked><span class="checkmark"></span><span class="label-text">✨ {{ __('messages.shop.easy') }}</span><span class="count">(89)</span></label></li>
                        <li><label class="checkbox-label"><input type="checkbox"><span class="checkmark"></span><span class="label-text">🔧 {{ __('messages.shop.medium') }}</span><span class="count">(76)</span></label></li>
                    </ul>
                </div>

                <!-- Promo Banner -->
                <div class="sidebar-widget promo-widget">
                    <div class="promo-content">
                        <span class="promo-tag">🌿 {{ __('messages.shop.promo') }}</span>
                        <h4>{{ __('messages.shop.discount', ['percent' => 25]) }}</h4>
                        <p>{{ __('messages.shop.promo') }}</p>
                        <a href="{{ route('shop') }}" class="btn-shop-now">{{ __('messages.shop.promo_btn') }}</a>
                    </div>
                </div>
            </aside>

            <!-- Main Shop Content -->
            <div class="shop-main">
                <!-- Shop Toolbar -->
                <div class="shop-toolbar">
                    <div class="results-info">
                        {{ __('messages.shop.showing') }} <span>1</span>-<span>{{ count($products) }}</span> {{ __('messages.shop.of') }} <span>{{ $categories->sum('count') }}</span> {{ __('messages.shop.plants') }}
                    </div>
                    <div class="toolbar-actions">
                        <form action="{{ route('shop') }}" method="GET" style="display:flex; gap:8px; align-items:center;">
                            <div style="position:relative;">
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="{{ __('messages.shop.search_placeholder') }}"
                                    style="padding:10px 16px 10px 38px; border:1px solid var(--border-color); border-radius:10px; font-size:14px; width:220px; outline:none;">
                                <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:13px;"></i>
                            </div>
                            <select class="sort-select" name="sort" onchange="this.form.submit()">
                                <option value="featured" {{ ($sort ?? 'featured') == 'featured' ? 'selected' : '' }}>{{ __('messages.shop.featured') }}</option>
                                <option value="newest" {{ ($sort ?? '') == 'newest' ? 'selected' : '' }}>{{ __('messages.shop.newest') }}</option>
                                <option value="price-low" {{ ($sort ?? '') == 'price-low' ? 'selected' : '' }}>{{ __('messages.shop.price_low') }}</option>
                                <option value="price-high" {{ ($sort ?? '') == 'price-high' ? 'selected' : '' }}>{{ __('messages.shop.price_high') }}</option>
                            </select>
                        </form>
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid"><i class="fas fa-th"></i></button>
                            <button class="view-btn" data-view="list"><i class="fas fa-list"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid" id="productsGrid">
                    @forelse($products as $product)
                    <div class="plant-card">
                        <div class="plant-image">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                            @if($product['badge'])
                            <span class="plant-badge {{ $product['badge'] }}">
                                @if($product['badge'] == 'sale') {{ __('messages.shop.discount', ['percent' => $product['discount'] ?? 0]) }}
                                @elseif($product['badge'] == 'new') New
                                @elseif($product['badge'] == 'rare') Rare
                                @else {{ ucfirst($product['badge']) }} @endif
                            </span>
                            @endif
                            <div class="plant-overlay">
                                <div class="plant-actions">
                                    <a href="{{ route('product.detail', $product['slug']) }}" class="plant-action-btn" title="{{ __('messages.shop.view_detail') }}"><i class="fas fa-eye"></i></a>
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        <button type="submit" class="plant-action-btn add-to-cart" title="{{ __('messages.button.add_to_cart') }}"><i class="fas fa-shopping-cart"></i></button>
                                    </form>
                                    @php $inWishlistShop = in_array($product['id'], $wishlistIds ?? []); @endphp
                                    <button type="button" class="plant-action-btn btn-wishlist {{ $inWishlistShop ? 'active' : '' }}" data-product-id="{{ $product['id'] }}" title="{{ __('messages.shop.favorite') }}">
                                        <i class="{{ $inWishlistShop ? 'fas' : 'far' }} fa-heart"></i>
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
                                <div class="care-icon" data-tooltip="{{ __('messages.shop.watering') }} {{ $product['watering'] }}">💧</div>
                                <div class="care-icon" data-tooltip="{{ __('messages.shop.light') }} {{ $product['light'] }}">🌤</div>
                                <div class="care-icon" data-tooltip="{{ $product['care_level'] }}">✨</div>
                            </div>
                            <div class="plant-price">
                                <span class="current">{{ $currency->format($product['price'], $currentCurrency) }}</span>
                                @if($product['original_price'])
                                <span class="original">{{ $currency->format($product['original_price'], $currentCurrency) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                        <i class="fas fa-leaf" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px;"></i>
                        <h3>{{ __('messages.shop.no_products') }}</h3>
                        <p style="color: var(--text-muted);">{{ __('messages.shop.change_filter') }}</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <a href="#" class="page-btn disabled"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="page-btn active">1</a>
                    <a href="#" class="page-btn">2</a>
                    <a href="#" class="page-btn">3</a>
                    <span class="page-dots">...</span>
                    <a href="#" class="page-btn">22</a>
                    <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
