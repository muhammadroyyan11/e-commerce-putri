@extends('layouts.app')

@section('title', (isset($pageTitle) ? $pageTitle : __('messages.shop.title')) . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

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
<section class="shop-section" style="padding: 40px 0 72px; background: var(--bg-light);">
    <div class="container">
        <div class="shop-layout">

            <!-- ── Sidebar ─────────────────────────────────── -->
            <aside class="shop-sidebar">

                {{-- Categories --}}
                <div class="sf-card">
                    <div class="sf-card__head">
                        <i class="fas fa-seedling"></i>
                        <span>{{ __('messages.shop.categories') }}</span>
                    </div>
                    <ul class="sf-cat-list">
                        <li>
                            <a href="{{ route('shop') }}" class="sf-cat-item {{ !request('category') ? 'sf-cat-item--active' : '' }}">
                                <span>{{ __('messages.shop.all_plants') }}</span>
                                <span class="sf-cat-count">{{ $categories->sum('count') }}</span>
                            </a>
                        </li>
                        @foreach([
                            ['route'=>'category.indoor',   'slug'=>'indoor',    'emoji'=>'🌿', 'label'=>__('messages.shop.indoor')],
                            ['route'=>'category.outdoor',  'slug'=>'outdoor',   'emoji'=>'☀️', 'label'=>__('messages.shop.outdoor')],
                            ['route'=>'category.succulent','slug'=>'succulent', 'emoji'=>'🌵', 'label'=>__('messages.shop.succulent')],
                            ['route'=>'category.rare',     'slug'=>'rare',      'emoji'=>'💎', 'label'=>__('messages.shop.rare')],
                        ] as $cat)
                        <li>
                            <a href="{{ route($cat['route']) }}" class="sf-cat-item {{ request('category') == $cat['slug'] ? 'sf-cat-item--active' : '' }}">
                                <span>{{ $cat['emoji'] }} {{ $cat['label'] }}</span>
                                <span class="sf-cat-count">{{ $categories->firstWhere('slug', $cat['slug'])?->count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Sort (mobile sidebar) --}}
                <div class="sf-card">
                    <div class="sf-card__head">
                        <i class="fas fa-sliders-h"></i>
                        <span>{{ __('messages.shop.sort') }}</span>
                    </div>
                    <form action="{{ route('shop') }}" method="GET">
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        <div class="sf-sort-list">
                            @foreach([
                                ['val'=>'featured',   'label'=>__('messages.shop.featured')],
                                ['val'=>'newest',     'label'=>__('messages.shop.newest')],
                                ['val'=>'price-low',  'label'=>__('messages.shop.price_low')],
                                ['val'=>'price-high', 'label'=>__('messages.shop.price_high')],
                            ] as $s)
                            <label class="sf-sort-item {{ ($sort ?? 'featured') == $s['val'] ? 'sf-sort-item--active' : '' }}">
                                <input type="radio" name="sort" value="{{ $s['val'] }}" {{ ($sort ?? 'featured') == $s['val'] ? 'checked' : '' }} onchange="this.form.submit()" style="display:none;">
                                {{ $s['label'] }}
                            </label>
                            @endforeach
                        </div>
                    </form>
                </div>

                {{-- Care Level --}}
                <div class="sf-card">
                    <div class="sf-card__head">
                        <i class="fas fa-leaf"></i>
                        <span>{{ __('messages.shop.care_level') }}</span>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        @foreach([['⭐',__('messages.shop.very_easy')],['✨',__('messages.shop.easy')],['🔧',__('messages.shop.medium')]] as [$icon,$label])
                        <label class="sf-check">
                            <input type="checkbox" style="display:none;">
                            <span class="sf-check__box"></span>
                            <span class="sf-check__label">{{ $icon }} {{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

            </aside>

            <!-- ── Main Content ───────────────────────────── -->
            <div class="shop-main">

                {{-- Toolbar --}}
                <div class="sf-toolbar">
                    <p class="sf-toolbar__count">
                        <span class="sf-toolbar__num">{{ count($products) }}</span> {{ __('messages.shop.plants') }}
                    </p>
                    <form action="{{ route('shop') }}" method="GET" class="sf-toolbar__form">
                        @if(request('sort') && request('sort') !== 'featured')
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        <div class="sf-search-wrap">
                            <i class="fas fa-search sf-search-icon"></i>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                placeholder="{{ __('messages.shop.search_placeholder') }}"
                                class="sf-search-input">
                        </div>
                        <select name="sort" class="sf-sort-select" onchange="this.form.submit()">
                            <option value="featured"   {{ ($sort??'featured')=='featured'  ?'selected':'' }}>{{ __('messages.shop.featured') }}</option>
                            <option value="newest"     {{ ($sort??'')=='newest'            ?'selected':'' }}>{{ __('messages.shop.newest') }}</option>
                            <option value="price-low"  {{ ($sort??'')=='price-low'         ?'selected':'' }}>{{ __('messages.shop.price_low') }}</option>
                            <option value="price-high" {{ ($sort??'')=='price-high'        ?'selected':'' }}>{{ __('messages.shop.price_high') }}</option>
                        </select>
                    </form>
                </div>

                {{-- Active filter chips --}}
                @if(request('search') || (request('sort') && request('sort') !== 'featured'))
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
                    @if(request('search'))
                    <a href="{{ route('shop', array_merge(request()->except('search'), [])) }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:#dcfce7;color:#166534;border-radius:999px;font-size:12px;font-weight:600;text-decoration:none;">
                        "{{ request('search') }}" <i class="fas fa-times" style="font-size:10px;"></i>
                    </a>
                    @endif
                    @if(request('sort') && request('sort') !== 'featured')
                    <a href="{{ route('shop', array_merge(request()->except('sort'), [])) }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:#dcfce7;color:#166534;border-radius:999px;font-size:12px;font-weight:600;text-decoration:none;">
                        {{ __('messages.shop.sort') }}: {{ request('sort') }} <i class="fas fa-times" style="font-size:10px;"></i>
                    </a>
                    @endif
                </div>
                @endif

                <!-- Products Grid -->
                <div class="products-grid" id="productsGrid">
                    @forelse($products as $product)
                        @include('partials.product-card', ['product' => $product, 'wishlistIds' => $wishlistIds])
                    @empty
                    <div style="grid-column:1/-1;text-align:center;padding:60px;">
                        <i class="fas fa-leaf" style="font-size:48px;color:var(--text-muted);margin-bottom:16px;display:block;"></i>
                        <h3>{{ __('messages.shop.no_products') }}</h3>
                        <p style="color:var(--text-muted);">{{ __('messages.shop.change_filter') }}</p>
                    </div>
                    @endforelse
                </div>

                {{-- Infinite scroll sentinel --}}
                <div id="scroll-sentinel" style="height:1px;margin-top:24px;"></div>

                {{-- Loading spinner --}}
                <div id="scroll-loader" style="display:none;">
                    <div class="products-grid" id="skeleton-grid">
                        @for($i = 0; $i < 3; $i++)
                        <div class="sk-card">
                            <div class="sk-img"></div>
                            <div class="sk-body">
                                <div class="sk-line sk-line--sm"></div>
                                <div class="sk-line sk-line--lg"></div>
                                <div class="sk-line sk-line--md"></div>
                                <div class="sk-specs">
                                    <div class="sk-line sk-line--xs"></div>
                                    <div class="sk-line sk-line--xs"></div>
                                </div>
                                <div class="sk-line sk-line--price"></div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- End of results --}}
                <div id="scroll-end" style="display:none;text-align:center;padding:24px 0;color:#9ca3af;font-size:13px;font-weight:600;">
                    ✅ {{ app()->getLocale()==='id' ? 'Semua produk sudah ditampilkan' : 'All products loaded' }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Skeleton cards ─────────────────────────────────── */
@keyframes sk-shimmer {
    0%   { background-position: -400px 0; }
    100% { background-position:  400px 0; }
}

.sk-card {
    background: #fff;
    border-radius: var(--radius-lg, 20px);
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

.sk-img {
    height: 220px;
    background: #f1f5f9;
    background-image: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
    background-size: 800px 100%;
    animation: sk-shimmer 1.4s infinite linear;
}

.sk-body { padding: 18px; display: flex; flex-direction: column; gap: 10px; }

.sk-line {
    border-radius: 6px;
    background: #f1f5f9;
    background-image: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
    background-size: 800px 100%;
    animation: sk-shimmer 1.4s infinite linear;
}

.sk-line--sm    { height: 10px; width: 40%; }
.sk-line--lg    { height: 16px; width: 75%; }
.sk-line--md    { height: 12px; width: 60%; }
.sk-line--xs    { height: 10px; width: 30%; }
.sk-line--price { height: 18px; width: 45%; margin-top: 4px; }

.sk-specs { display: flex; gap: 16px; }
</style>
@endpush

@push('styles')
<style>
/* ── Sidebar filter cards ──────────────────────────── */
.sf-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

.sf-card__head {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #374151;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.sf-card__head i {
    color: var(--primary-color);
    font-size: 14px;
}

/* Category list */
.sf-cat-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 2px; }

.sf-cat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    color: #4b5563;
    text-decoration: none;
    transition: background .15s, color .15s;
}

.sf-cat-item:hover { background: #f0fdf4; color: #059669; }
.sf-cat-item--active { background: #dcfce7; color: #166534; font-weight: 700; }

.sf-cat-count {
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #6b7280;
    padding: 2px 8px;
    border-radius: 999px;
}

.sf-cat-item--active .sf-cat-count { background: #bbf7d0; color: #166534; }

/* Sort radio list */
.sf-sort-list { display: flex; flex-direction: column; gap: 2px; }

.sf-sort-item {
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    color: #4b5563;
    cursor: pointer;
    transition: background .15s, color .15s;
}

.sf-sort-item:hover { background: #f0fdf4; color: #059669; }
.sf-sort-item--active { background: #dcfce7; color: #166534; font-weight: 700; }

/* Checkboxes */
.sf-check {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 4px;
    cursor: pointer;
}

.sf-check__box {
    width: 18px; height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 5px;
    flex-shrink: 0;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sf-check input:checked ~ .sf-check__box {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.sf-check__label { font-size: 14px; color: #4b5563; }

/* ── Toolbar ───────────────────────────────────────── */
.sf-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: white;
    border-radius: 14px;
    padding: 12px 16px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    gap: 12px;
    flex-wrap: wrap;
}

.sf-toolbar__count {
    font-size: 14px;
    color: #6b7280;
    white-space: nowrap;
    margin: 0;
}

.sf-toolbar__num { font-weight: 700; color: #111827; }

.sf-toolbar__form {
    display: flex;
    gap: 10px;
    align-items: center;
    flex: 1;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.sf-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.sf-search-icon {
    position: absolute;
    left: 12px;
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
}

.sf-search-input {
    padding: 9px 14px 9px 36px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13.5px;
    width: 200px;
    outline: none;
    transition: border-color .15s;
    font-family: inherit;
    background: #fafafa;
}

.sf-search-input:focus { border-color: #10b981; background: white; }

.sf-sort-select {
    padding: 9px 32px 9px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    color: #374151;
    outline: none;
    cursor: pointer;
    background: #fafafa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 10px center;
    -webkit-appearance: none;
    appearance: none;
    font-family: inherit;
    transition: border-color .15s;
}

.sf-sort-select:focus { border-color: #10b981; background-color: white; }

@media (max-width: 640px) {
    .sf-toolbar { flex-direction: column; align-items: flex-start; }
    .sf-toolbar__form { width: 100%; justify-content: stretch; }
    .sf-search-input { width: 100%; }
    .sf-sort-select  { width: 100%; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    let page     = 2;
    let loading  = false;
    let hasMore  = {{ $paginated->hasMorePages() ? 'true' : 'false' }};
    const grid   = document.getElementById('productsGrid');
    const loader = document.getElementById('scroll-loader');
    const endMsg = document.getElementById('scroll-end');
    const sentinel = document.getElementById('scroll-sentinel');

    if (!hasMore) {
        endMsg.style.display = 'block';
        return;
    }

    async function loadMore() {
        if (loading || !hasMore) return;
        loading = true;
        loader.style.display = 'block';

        try {
            const params = new URLSearchParams(window.location.search);
            params.set('page', page);

            const res  = await fetch('{{ route('shop') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const data = await res.json();

            grid.insertAdjacentHTML('beforeend', data.html);
            hasMore = data.has_more;
            page    = data.next_page;

            // Re-bind wishlist buttons on new cards
            grid.querySelectorAll('.btn-wishlist:not([data-bound])').forEach(btn => {
                btn.setAttribute('data-bound', '1');
                btn.addEventListener('click', handleWishlist);
            });

            if (!hasMore) {
                endMsg.style.display = 'block';
                observer.disconnect();
            }
        } catch (e) {
            console.error('Infinite scroll error', e);
        } finally {
            loading = false;
            loader.style.display = 'none';
        }
    }

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) loadMore();
    }, { rootMargin: '200px' });

    observer.observe(sentinel);

    // Wishlist handler (same pattern as existing)
    function handleWishlist() {
        const productId = this.dataset.productId;
        const btn = this;
        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success && data.redirect) { window.location.href = data.redirect; return; }
            const icon = btn.querySelector('i');
            if (data.status === 'added') {
                icon.className = 'fas fa-heart';
                btn.classList.add('active');
            } else {
                icon.className = 'far fa-heart';
                btn.classList.remove('active');
            }
        });
    }

    // Bind existing cards
    grid.querySelectorAll('.btn-wishlist').forEach(btn => {
        btn.setAttribute('data-bound', '1');
        btn.addEventListener('click', handleWishlist);
    });
})();
</script>
@endpush
