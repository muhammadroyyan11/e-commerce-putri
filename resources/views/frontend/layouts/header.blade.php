{{-- ===== SVG ICON DEFS (Organik Icons) ===== --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none;">
  <defs>
    <symbol id="icon-cart" viewBox="0 0 24 24"><path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/></symbol>
    <symbol id="icon-heart" viewBox="0 0 24 24"><path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z"/></symbol>
    <symbol id="icon-search" viewBox="0 0 24 24"><path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/></symbol>
    <symbol id="icon-user" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="3"/><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5"/></g></symbol>
    <symbol id="icon-menu" viewBox="0 0 24 24"><path fill="currentColor" d="M2 6a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 6a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m1 5a1 1 0 1 0 0 2h18a1 1 0 0 0 0-2z"/></symbol>
  </defs>
</svg>

@php
    $settings = DB::table('settings')->first();
    $allCategories = \App\Models\Category::where('is_parent', 1)->orderBy('title')->take(8)->get();
@endphp

{{-- ===== TOPBAR ===== --}}
<div class="topbar-organik">
    <div class="container-fluid px-3 px-lg-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                @if(($settings->phone ?? null))
                    <span><i class="fas fa-phone-alt me-1"></i>{{ $settings->phone }}</span>
                @endif
                @if(($settings->email ?? null))
                    <span class="d-none d-md-inline"><i class="fas fa-envelope me-1"></i>{{ $settings->email }}</span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('order.track') }}"><i class="fas fa-map-marker-alt me-1"></i>Track Order</a>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin') }}" target="_blank"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    @else
                        <a href="{{ route('user') }}" target="_blank"><i class="fas fa-user me-1"></i>Dashboard</a>
                    @endif
                    <a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
                @else
                    <a href="{{ route('login.form') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    <a href="{{ route('register.form') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- ===== MAIN HEADER ===== --}}
<header class="organik-header">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center py-3 g-2">

            {{-- Logo --}}
            <div class="col-6 col-lg-2">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none header-logo">
                    @if(($settings->logo ?? null))
                        <img src="{{ $settings->logo }}" alt="Logo">
                    @else
                        <img src="{{ asset('template-organik/images/logo.svg') }}" alt="Logo">
                    @endif
                    @if(($settings->name ?? null))
                        <span class="d-none d-md-inline">{{ $settings->name }}</span>
                    @endif
                </a>
            </div>

            {{-- Search --}}
            <div class="col-12 col-lg-6 order-3 order-lg-2 mt-2 mt-lg-0">
                <form method="POST" action="{{ route('product.search') }}">
                    @csrf
                    <div class="search-wrap">
                        <select name="category_s" class="d-none d-md-block">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Category::where('is_parent',1)->get() as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->title }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="search" placeholder="Search products..." required>
                        <button type="submit">
                            <svg width="20" height="20"><use xlink:href="#icon-search"></use></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Actions --}}
            <div class="col-6 col-lg-4 order-2 order-lg-3">
                <div class="d-flex justify-content-end align-items-center gap-1 gap-md-2 header-actions">

                    {{-- Wishlist --}}
                    <div class="position-relative">
                        <a href="{{ route('wishlist') }}" class="d-flex align-items-center gap-1 px-2 py-2" title="Wishlist">
                            <svg width="22" height="22"><use xlink:href="#icon-heart"></use></svg>
                            <span class="badge-count">{{ Helper::wishlistCount() }}</span>
                        </a>
                    </div>

                    {{-- Cart --}}
                    <div class="position-relative">
                        <a href="{{ route('cart') }}" class="d-flex align-items-center gap-1 px-2 py-2" title="Cart">
                            <svg width="22" height="22"><use xlink:href="#icon-cart"></use></svg>
                            <span class="badge-count">{{ Helper::cartCount() }}</span>
                        </a>
                    </div>

                    {{-- User Dropdown --}}
                    @auth
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center gap-1 px-2 py-2 text-dark text-decoration-none" data-bs-toggle="dropdown">
                            <svg width="22" height="22"><use xlink:href="#icon-user"></use></svg>
                            <span class="d-none d-md-inline small fw-bold" style="max-width:90px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down small ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1">
                            @if(Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin') }}" target="_blank"><i class="fas fa-cog text-success me-2"></i>Admin Panel</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('user') }}"><i class="fas fa-user text-success me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.order.index') }}"><i class="fas fa-box text-success me-2"></i>My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-cog text-success me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item text-danger" href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login.form') }}" class="btn btn-success btn-sm rounded-pill px-3 ms-1 d-none d-md-inline-flex align-items-center gap-1">
                        <i class="fas fa-sign-in-alt"></i><span>Login</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Category Strip Nav --}}
        <div class="cat-nav-strip d-none d-lg-block">
            <nav class="d-flex overflow-auto align-items-center" style="gap: 0">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('product-grids') }}" class="nav-link {{ request()->routeIs('product-grids') ? 'active' : '' }}">All Products</a>
                @foreach($allCategories as $cat)
                    <a href="{{ route('product-cat', $cat->slug) }}" class="nav-link {{ request()->segment(2) == $cat->slug ? 'active' : '' }}">{{ $cat->title }}</a>
                @endforeach
                <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </nav>
        </div>
    </div>
</header>