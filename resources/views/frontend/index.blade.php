@extends('frontend.layouts.master')
@section('title', ($settings_header->name ?? 'Shop') . ' - Home')

@section('main-content')

{{-- ============ HERO CAROUSEL ============ --}}
@if(count($banners) > 0)
<section class="position-relative overflow-hidden">
    <div id="heroBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $key => $banner)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="background-image:url('{{ $banner->photo }}');background-size:cover;background-position:center;min-height:420px;display:flex;align-items:center;">
                <div class="container py-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h1 class="display-5 fw-bold" style="font-family:'Nunito',sans-serif;color:#1a1a1a">{{ $banner->title }}</h1>
                            <p class="fs-5 text-muted mt-3">{!! html_entity_decode($banner->description) !!}</p>
                            <a href="{{ route('product-grids') }}" class="btn btn-success rounded-pill px-4 py-2 mt-3 fw-bold">
                                Shop Now <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if(count($banners) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        @endif
    </div>

    {{-- Feature Badges overlapping bottom --}}
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-4" style="background:#4caf50;color:#fff">
                    <i class="fas fa-truck fs-2"></i>
                    <div><div class="fw-bold">Fast Delivery</div><div class="small opacity-75">Right to your doorstep</div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-4" style="background:#388e3c;color:#fff">
                    <i class="fas fa-shield-alt fs-2"></i>
                    <div><div class="fw-bold">Secure Payment</div><div class="small opacity-75">100% safe & secure</div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-4" style="background:#2e7d32;color:#fff">
                    <i class="fas fa-undo fs-2"></i>
                    <div><div class="fw-bold">Easy Returns</div><div class="small opacity-75">30-day hassle free</div></div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
{{-- No banner placeholder --}}
<section style="background:linear-gradient(135deg,#e8f5e9,#f1f8e9);padding:80px 0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                @php $s = DB::table('settings')->first(); @endphp
                <h1 class="display-5 fw-bold" style="font-family:'Nunito',sans-serif;color:#1b5e20">{{ $s->name ?? 'Our Store' }}</h1>
                <p class="fs-5 text-muted mt-3">{{ $s->short_des ?? 'Discover quality products at amazing prices.' }}</p>
                <a href="{{ route('product-grids') }}" class="btn btn-success rounded-pill px-4 py-2 mt-3 fw-bold">Shop Now <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('template-organik/images/banner-1.jpg') }}" class="img-fluid rounded-4 shadow" alt="Shop">
            </div>
        </div>
        <div class="row g-0 mt-5">
            <div class="col-md-4"><div class="d-flex align-items-center gap-3 p-4 rounded-3" style="background:#4caf50;color:#fff"><i class="fas fa-truck fs-2"></i><div><div class="fw-bold">Fast Delivery</div><div class="small opacity-75">Right to your doorstep</div></div></div></div>
            <div class="col-md-4"><div class="d-flex align-items-center gap-3 p-4 rounded-3 ms-2" style="background:#388e3c;color:#fff"><i class="fas fa-shield-alt fs-2"></i><div><div class="fw-bold">Secure Payment</div><div class="small opacity-75">100% safe & secure</div></div></div></div>
            <div class="col-md-4"><div class="d-flex align-items-center gap-3 p-4 rounded-3 ms-2" style="background:#2e7d32;color:#fff"><i class="fas fa-undo fs-2"></i><div><div class="fw-bold">Easy Returns</div><div class="small opacity-75">30-day hassle free</div></div></div></div>
        </div>
    </div>
</section>
@endif

{{-- ============ CATEGORY CAROUSEL ============ --}}
@php
    $home_categories = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
@endphp
@if($home_categories->count() > 0)
<section class="py-5 overflow-hidden">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold" style="font-family:'Nunito',sans-serif;font-size:1.5rem">Shop by Category</h2>
            <div class="d-flex gap-2">
                <button class="category-prev btn btn-sm" style="background:#fff3e0;color:#e65100;border:none;border-radius:6px;padding:6px 14px">❮</button>
                <button class="category-next btn btn-sm" style="background:#fff3e0;color:#e65100;border:none;border-radius:6px;padding:6px 14px">❯</button>
            </div>
        </div>
        <div class="category-carousel swiper">
            <div class="swiper-wrapper">
                @foreach($home_categories as $i => $cat)
                <a href="{{ route('product-cat', $cat->slug) }}" class="swiper-slide nav-link text-center py-2">
                    @if($cat->photo)
                        <img src="{{ $cat->photo }}" class="cat-carousel-img" alt="{{ $cat->title }}">
                    @else
                        <img src="{{ asset('template-organik/images/category-thumb-'.( ($i % 8) + 1).'.jpg') }}" class="cat-carousel-img" alt="{{ $cat->title }}">
                    @endif
                    <span class="cat-label">{{ $cat->title }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ TRENDING PRODUCTS ============ --}}
<section class="pb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold" style="font-family:'Nunito',sans-serif;font-size:1.5rem">Trending Products</h2>
            <div>
                {{-- Category Filter Buttons --}}
                @php
                    $filter_cats = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                @endphp
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-success btn-sm rounded-pill px-3 filter-btn how-active1" data-filter="*">All</button>
                    @foreach($filter_cats as $cat)
                        <button class="btn btn-outline-success btn-sm rounded-pill px-3 filter-btn" data-filter=".cat-{{ $cat->id }}">{{ $cat->title }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-3 isotope-grid" id="product-grid">
            @if($product_lists)
            @foreach($product_lists as $product)
            @php $photo = explode(',', $product->photo); @endphp
            <div class="col isotope-item cat-{{ $product->cat_id }}">
                <div class="product-item">
                    <figure>
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}" style="height:170px;object-fit:contain;width:100%">
                        </a>
                        {{-- Badges --}}
                        @if($product->stock <= 0)
                            <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Out of Stock</span>
                        @elseif($product->condition == 'new')
                            <span class="badge bg-info position-absolute top-0 start-0 m-2">New</span>
                        @elseif($product->condition == 'hot')
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">Hot</span>
                        @elseif($product->discount > 0)
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">{{ $product->discount }}% OFF</span>
                        @endif
                    </figure>
                    <div class="info">
                        <a href="{{ route('product-detail', $product->slug) }}" class="text-decoration-none">
                            <h3>{{ Str::limit($product->title, 40) }}</h3>
                        </a>
                        @php $after_discount = $product->price - ($product->price * $product->discount / 100); @endphp
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="price">${{ number_format($after_discount, 2) }}</span>
                            @if($product->discount > 0)
                                <span class="price-old">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart flex-grow-1 text-center text-decoration-none">
                                <i class="fas fa-cart-plus me-1"></i>Add to Cart
                            </a>
                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-sm" title="Wishlist">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('product-grids') }}" class="btn btn-outline-success rounded-pill px-5 py-2">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ============ FEATURED PRODUCTS ============ --}}
@if($featured && count($featured) > 0)
<section class="py-5" style="background:#f9fafb">
    <div class="container">
        <h2 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif;font-size:1.5rem">Featured Products</h2>
        <div class="row g-3">
            @foreach($featured as $data)
            @php $photo = explode(',', $data->photo); @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 product-item">
                    <figure class="m-0">
                        <a href="{{ route('product-detail', $data->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $data->title }}" style="height:200px;object-fit:cover;width:100%">
                        </a>
                    </figure>
                    <div class="info">
                        <span class="badge bg-success-subtle text-success">{{ $data->cat_info['title'] ?? '' }}</span>
                        <h3 class="mt-1">{{ $data->title }}</h3>
                        @php $fd = $data->price - ($data->price * $data->discount / 100); @endphp
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="price">${{ number_format($fd, 2) }}</span>
                            @if($data->discount > 0)
                                <span class="price-old">${{ number_format($data->price, 2) }}</span>
                                <span class="badge bg-danger">{{ $data->discount }}% OFF</span>
                            @endif
                        </div>
                        <a href="{{ route('add-to-cart', $data->slug) }}" class="btn-add-cart d-block text-center text-decoration-none">
                            <i class="fas fa-cart-plus me-1"></i>Add to Cart
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ BLOG ============ --}}
@if($posts && count($posts) > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold" style="font-family:'Nunito',sans-serif;font-size:1.5rem">From Our Blog</h2>
            <a href="{{ route('blog') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">View All</a>
        </div>
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                    <img src="{{ $post->photo }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $post->title }}">
                    <div class="card-body">
                        <p class="text-muted small mb-1"><i class="fas fa-calendar me-1"></i>{{ $post->created_at->format('d M Y') }}</p>
                        <h5 class="card-title fw-bold" style="font-family:'Nunito',sans-serif">{{ Str::limit($post->title, 50) }}</h5>
                        <a href="{{ route('blog.detail', $post->slug) }}" class="btn btn-outline-success btn-sm rounded-pill mt-2">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ NEWSLETTER ============ --}}
@include('frontend.layouts.newsletter')

{{-- ============ QUICK VIEW MODALS ============ --}}
@if($product_lists)
@foreach($product_lists as $product)
@php $photo = explode(',', $product->photo); @endphp
<div class="modal fade" id="modal-{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">{{ $product->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-5">
                        <img src="{{ $photo[0] }}" class="img-fluid rounded-3" alt="{{ $product->title }}">
                    </div>
                    <div class="col-md-7">
                        @php
                            $after_discount = $product->price - ($product->price * $product->discount / 100);
                            $rate = DB::table('product_reviews')->where('product_id', $product->id)->avg('rate');
                        @endphp
                        <div class="mb-2">
                            @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star {{ $rate >= $i ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <h3 class="fw-bold text-success">${{ number_format($after_discount, 2) }}
                            @if($product->discount > 0)<small class="text-muted text-decoration-line-through ms-2 fs-5">${{ number_format($product->price, 2) }}</small>@endif
                        </h3>
                        <p class="text-muted">{!! html_entity_decode($product->summary) !!}</p>
                        <form action="{{ route('single-add-to-cart') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $product->slug }}">
                            <div class="d-flex gap-2 align-items-center mb-3">
                                <label class="fw-bold mb-0">Qty:</label>
                                <input type="number" name="quant[1]" value="1" min="1" max="1000" class="form-control" style="width:80px">
                            </div>
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn btn-outline-danger rounded-pill px-4 ms-2">
                                <i class="fas fa-heart me-2"></i>Wishlist
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection

@push('styles')
<style>
    .isotope-item { position: relative; }
    .isotope-item figure { position: relative; overflow: hidden; }
    .filter-btn.how-active1 { background: #4caf50 !important; color: #fff !important; border-color: #4caf50 !important; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
<script>
// Isotope filter
$(window).on('load', function() {
    var $grid = $('.isotope-grid').isotope({
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows'
    });
    $('.filter-btn').on('click', function() {
        var filter = $(this).data('filter');
        $grid.isotope({ filter: filter == '*' ? '*' : '.' + filter.replace('.','') });
        $('.filter-btn').removeClass('how-active1');
        $(this).addClass('how-active1');
    });
});

// Category Swiper
new Swiper('.category-carousel', {
    slidesPerView: 3, spaceBetween: 12, loop: true,
    navigation: { prevEl: '.category-prev', nextEl: '.category-next' },
    breakpoints: { 576:{slidesPerView:4}, 768:{slidesPerView:5}, 992:{slidesPerView:7} }
});
</script>
@endpush
