@extends('layouts.app')

@section('title', $product['name'] . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

@push('styles')
<style>
/* ── Product Detail ─────────────────────────────────── */
.pd-section { padding: 48px 0 72px; background: #ffffff; }
.pd-grid    { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start; }

/* Gallery */
.pd-gallery {}
.pd-main-img {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.08);
    position: relative;
}
.pd-main-img img { width: 100%; height: 520px; object-fit: cover; display: block; }
.pd-badge-overlay {
    position: absolute; top: 20px; left: 20px;
    background: var(--error-color); color: white;
    padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 700;
}

/* Info */
.pd-info {}
.pd-category-tag {
    display: inline-block;
    background: var(--primary-light); color: var(--primary-dark);
    padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600;
    margin-bottom: 14px;
}
.pd-title { font-size: 30px; font-weight: 800; color: var(--text-dark); line-height: 1.25; margin-bottom: 12px; }

/* Rating summary */
.pd-rating-row { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.stars-display  { display: flex; gap: 3px; }
.stars-display i { font-size: 15px; color: #f59e0b; }
.stars-display i.empty { color: #d1d5db; }
.pd-rating-count { font-size: 14px; color: var(--text-muted); }

/* Price */
.pd-price-row { display: flex; align-items: center; gap: 14px; padding: 20px 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); margin-bottom: 22px; }
.pd-price     { font-size: 34px; font-weight: 800; color: var(--primary-dark); }
.pd-price-old { font-size: 20px; color: var(--text-muted); text-decoration: line-through; }
.pd-discount  { background: var(--error-color); color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }

/* Stock */
.pd-stock { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
.pd-stock.in  { color: #16a34a; }
.pd-stock.out { color: #dc2626; }

/* Short desc */
.pd-desc { color: var(--text-medium); line-height: 1.75; margin-bottom: 22px; font-size: 15px; }
.pd-desc p { margin-bottom: 10px; }
.pd-desc ul, .pd-desc ol { padding-left: 20px; margin-bottom: 10px; }
.pd-desc strong { color: var(--text-dark); }

/* Care cards */
.pd-care-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
.pd-care-card {
    background: white; border-radius: 16px; padding: 16px 12px; text-align: center;
    border: 1px solid var(--border-color);
}
.pd-care-icon { font-size: 22px; margin-bottom: 6px; }
.pd-care-label { font-size: 11px; color: var(--text-muted); display: block; margin-bottom: 3px; }
.pd-care-value { font-size: 13px; font-weight: 700; color: var(--text-dark); }

/* Qty + cart */
.pd-qty-row { display: flex; gap: 12px; align-items: center; }
.qty-box { display: flex; border: 1.5px solid var(--border-color); border-radius: 12px; overflow: hidden; }
.qty-box button { width: 46px; height: 52px; font-size: 18px; background: none; border: none; cursor: pointer; color: var(--text-medium); }
.qty-box input  { width: 56px; text-align: center; border: none; border-left: 1.5px solid var(--border-color); border-right: 1.5px solid var(--border-color); font-weight: 700; font-size: 16px; }
.btn-cart-main {
    flex: 1; height: 52px; background: var(--gradient-primary); color: white;
    border: none; border-radius: 12px; font-weight: 700; font-size: 15px;
    display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer;
    transition: opacity .2s;
}
.btn-cart-main:hover { opacity: .88; }
.btn-wishlist-main {
    width: 52px; height: 52px; border: 1.5px solid var(--border-color); border-radius: 12px;
    font-size: 20px; color: var(--text-light); background: white; cursor: pointer; transition: all .2s;
}
.btn-wishlist-main.active, .btn-wishlist-main:hover { border-color: #f43f5e; color: #f43f5e; }

/* ── Reviews ─────────────────────────────────────────── */
.reviews-section { padding: 60px 0; background: white; }
.reviews-header  { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 36px; flex-wrap: wrap; gap: 16px; }
.reviews-title   { font-size: 26px; font-weight: 800; }
.reviews-summary { display: flex; align-items: center; gap: 16px; }
.avg-score { font-size: 52px; font-weight: 900; color: var(--primary-dark); line-height: 1; }
.avg-meta  { display: flex; flex-direction: column; gap: 4px; }

.review-card {
    background: #f8fafc; border-radius: 20px; padding: 24px;
    border: 1px solid var(--border-color); margin-bottom: 16px;
}
.review-top  { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
.review-user { display: flex; align-items: center; gap: 12px; }
.review-avatar {
    width: 44px; height: 44px; border-radius: 50%; background: var(--primary-light);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 16px; color: var(--primary-dark); flex-shrink: 0;
}
.review-name  { font-weight: 700; font-size: 15px; color: var(--text-dark); }
.review-date  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
.review-badge { font-size: 11px; background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
.review-stars { display: flex; gap: 3px; margin-bottom: 10px; }
.review-stars i { font-size: 14px; color: #f59e0b; }
.review-stars i.empty { color: #d1d5db; }
.review-comment { color: var(--text-medium); line-height: 1.7; font-size: 14px; }

.empty-reviews { text-align: center; padding: 48px 24px; color: var(--text-muted); }
.empty-reviews i { font-size: 40px; margin-bottom: 12px; display: block; color: #d1d5db; }

/* ── Related ─────────────────────────────────────────── */
.related-section { padding: 60px 0; background: #ffffff; }

/* ── AI Chat quick buttons ───────────────────────────── */
.ai-quick {
    padding: 7px 14px; border-radius: 20px; border: 1.5px solid #86efac;
    background: white; color: #166534; font-size: 13px; cursor: pointer;
    font-family: inherit; transition: all .15s;
}
.ai-quick:hover { background: #f0fdf4; border-color: #4ade80; }
@media (max-width: 900px) {
    .pd-grid { grid-template-columns: 1fr; gap: 28px; }
    .pd-main-img img { height: 340px; }
    .pd-title { font-size: 24px; }
    .pd-price { font-size: 26px; }
}
@media (max-width: 600px) {
    .pd-care-grid { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .reviews-header { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
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

{{-- Product Detail --}}
<section class="pd-section">
    <div class="container">
        <div class="pd-grid">

            {{-- Gallery --}}
            <div class="pd-gallery">
                <div class="pd-main-img">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" id="mainProductImage">
                    @if($product['discount'])
                        <div class="pd-badge-overlay">-{{ $product['discount'] }}%</div>
                    @endif
                </div>
                @if($productImages->count() > 1)
                <div class="pd-thumbs" style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
                    @foreach($productImages as $img)
                    <div class="pd-thumb {{ $img->is_primary ? 'active' : '' }}"
                         onclick="switchImage('{{ $img->url }}', this)"
                         style="width:72px; height:72px; border-radius:12px; overflow:hidden; cursor:pointer;
                                border:2px solid {{ $img->is_primary ? 'var(--primary-color)' : 'var(--border-color)' }};
                                flex-shrink:0; transition:border-color .2s;">
                        <img src="{{ $img->url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="pd-info">
                <span class="pd-category-tag">{{ $product['category'] }}</span>
                <h1 class="pd-title">{{ $product['name'] }}</h1>

                {{-- Rating summary --}}
                <div class="pd-rating-row">
                    <div class="stars-display">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($avgRating) ? '' : ' empty' }}"></i>
                        @endfor
                    </div>
                    <span class="pd-rating-count">
                        @if($reviewCount > 0)
                            {{ number_format($avgRating, 1) }} ({{ __('messages.product.reviews_count', ['count' => $reviewCount]) }})
                        @else
                            {{ __('messages.product.no_reviews') }}
                        @endif
                    </span>
                </div>

                {{-- Price --}}
                <div class="pd-price-row">
                    <span class="pd-price">{{ $currency->format($product['price'], $currentCurrency) }}</span>
                    @if($product['original_price'])
                        <span class="pd-price-old">{{ $currency->format($product['original_price'], $currentCurrency) }}</span>
                        <span class="pd-discount">-{{ $product['discount'] }}%</span>
                    @endif
                </div>

                {{-- Stock --}}
                @if(($product['stock'] ?? 0) > 0)
                    <div class="pd-stock in"><i class="fas fa-check-circle"></i> {{ __('messages.product.stock_available', ['count' => $product['stock']]) }}</div>
                @else
                    <div class="pd-stock out"><i class="fas fa-times-circle"></i> {{ __('messages.product.stock_empty') }}</div>
                @endif

                {{-- Short desc --}}
                @if($product['description'])
                    <div class="pd-desc">{!! $product['description'] !!}</div>
                @else
                    <p class="pd-desc">
                        {{ $product['name'] }} {{ app()->getLocale() == 'id' ? 'adalah tanaman hias populer dengan perawatan' : 'is a popular ornamental plant with' }}
                        {{ pval($product['care_level']) }}.
                        {{ app()->getLocale() == 'id' ? 'Cocok untuk' : 'Suitable for' }}
                        {{ strtolower($product['category']) }}
                        {{ app()->getLocale() == 'id' ? 'dengan kebutuhan cahaya' : 'with light needs' }}
                        {{ pval($product['light']) }}.
                    </p>
                @endif

                {{-- Care cards --}}
                <div class="pd-care-grid">
                    <div class="pd-care-card">
                        <div class="pd-care-icon">💧</div>
                        <span class="pd-care-label">{{ __('messages.shop.watering') }}</span>
                        <span class="pd-care-value">{{ pval($product['watering']) }}</span>
                    </div>
                    <div class="pd-care-card">
                        <div class="pd-care-icon">☀️</div>
                        <span class="pd-care-label">{{ __('messages.shop.light') }}</span>
                        <span class="pd-care-value">{{ pval($product['light']) }}</span>
                    </div>
                    <div class="pd-care-card">
                        <div class="pd-care-icon">📏</div>
                        <span class="pd-care-label">{{ __('messages.shop.height') }}</span>
                        <span class="pd-care-value">{{ $product['height'] }}</span>
                    </div>
                </div>

                {{-- Add to cart --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <label style="display:block; font-weight:600; margin-bottom:10px; font-size:14px;">{{ __('messages.product.quantity') }}</label>
                    <div class="pd-qty-row">
                        <div class="qty-box">
                            <button type="button" class="qty-btn minus">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product['stock'] ?? 10 }}" id="productQty">
                            <button type="button" class="qty-btn plus">+</button>
                        </div>
                        <button type="submit" class="btn-cart-main" {{ ($product['stock'] ?? 0) < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart"></i> {{ __('messages.button.add_to_cart') }}
                        </button>
                        <button type="button"
                            class="btn-wishlist-main {{ $inWishlist ? 'active' : '' }}"
                            data-product-id="{{ $product['id'] }}">
                            <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Reviews Section --}}
<section class="reviews-section">
    <div class="container">
        <div class="reviews-header">
            <div>
                <h2 class="reviews-title">{{ __('messages.product.reviews_title') }}</h2>
                <p style="color:var(--text-muted); margin-top:4px;">{{ __('messages.product.reviews_subtitle') }}</p>
            </div>
            @if($reviewCount > 0)
            <div class="reviews-summary">
                <div class="avg-score">{{ number_format($avgRating, 1) }}</div>
                <div class="avg-meta">
                    <div class="stars-display">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($avgRating) ? '' : ' empty' }}" style="font-size:18px;"></i>
                        @endfor
                    </div>
                    <span style="font-size:13px; color:var(--text-muted);">{{ __('messages.product.reviews_count', ['count' => $reviewCount]) }}</span>
                </div>
            </div>
            @endif
        </div>

        @if($reviews->count() > 0)
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="review-top">
                    <div class="review-user">
                        <div class="review-avatar">{{ strtoupper(substr($review['name'], 0, 1)) }}</div>
                        <div>
                            <div class="review-name">{{ $review['name'] }}</div>
                            <div class="review-date">{{ $review['date'] }}</div>
                        </div>
                    </div>
                    @if($review['verified'])
                        <span class="review-badge"><i class="fas fa-check-circle" style="margin-right:4px;"></i>{{ __('messages.product.verified_purchase') }}</span>
                    @endif
                </div>
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $review['rating'] ? '' : ' empty' }}"></i>
                    @endfor
                </div>
                @if($review['comment'])
                    <p class="review-comment">{{ $review['comment'] }}</p>
                @endif
            </div>
            @endforeach
        @else
            <div class="empty-reviews">
                <i class="far fa-comment-dots"></i>
                <p style="font-size:16px; font-weight:600; margin-bottom:6px;">{{ __('messages.product.no_reviews') }}</p>
                <p style="font-size:14px;">{{ __('messages.product.no_reviews_desc') }}</p>
            </div>
        @endif
    </div>
</section>

{{-- Related Products --}}
<section class="related-section">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:36px; flex-wrap:wrap; gap:12px;">
            <div>
                <h2 style="font-size:26px; font-weight:800;">{{ __('messages.product.similar_products') }}</h2>
                <p style="color:var(--text-light); margin-top:4px;">{{ __('messages.product.similar_desc') }}</p>
            </div>
            <a href="{{ route('shop') }}" style="display:flex; align-items:center; gap:8px; color:var(--primary-color); font-weight:600; text-decoration:none;">
                {{ __('messages.button.view_all') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="products-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:24px;">
            @foreach($relatedProducts as $related)
            <div class="plant-card">
                <div class="plant-image" style="height:200px;">
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

@push('scripts')
<script>
// Gallery thumbnail switcher
function switchImage(url, el) {
    document.getElementById('mainProductImage').src = url;
    document.querySelectorAll('.pd-thumb').forEach(t => {
        t.style.borderColor = 'var(--border-color)';
        t.classList.remove('active');
    });
    el.style.borderColor = 'var(--primary-color)';
    el.classList.add('active');
}

// Qty buttons
document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById('productQty');
        let val = parseInt(input.value) || 1;
        if (btn.classList.contains('plus'))  val = Math.min(val + 1, parseInt(input.max) || 99);
        if (btn.classList.contains('minus')) val = Math.max(val - 1, 1);
        input.value = val;
    });
});

// Wishlist toggle
const wishlistBtn = document.querySelector('.btn-wishlist-main');
if (wishlistBtn) {
    wishlistBtn.addEventListener('click', function () {
        const productId = this.dataset.productId;
        fetch('{{ route("wishlist.toggle") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.Laravel.csrfToken },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success && data.redirect) { window.location.href = data.redirect; return; }
            const icon = this.querySelector('i');
            if (data.status === 'added') {
                icon.className = 'fas fa-heart';
                this.classList.add('active');
            } else {
                icon.className = 'far fa-heart';
                this.classList.remove('active');
            }
        });
    });
}
</script>
@endpush
