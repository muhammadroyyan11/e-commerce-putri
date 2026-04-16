@php
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Setting;

$siteName     = Setting::get('site_name', 'LongLeaf');
$siteLogo     = Setting::get('site_logo', '');
$cartCount    = auth()->check() ? Cart::where('user_id', auth()->id())->count() : 0;
$wishlistCount= auth()->check() ? Wishlist::where('user_id', auth()->id())->count() : 0;
@endphp

<header class="header">
    <div class="container">
        <div class="header-wrapper">

            {{-- Hamburger — kiri, mobile only --}}
            <button class="mobile-menu-btn" onclick="toggleDrawer()" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="logo">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="height:32px;margin-right:8px;">
                @else
                    <i class="fas fa-leaf"></i>
                @endif
                <span>{{ $siteName }}</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="nav-menu" id="desktop-nav">
                <a href="{{ route('home') }}"       class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.menu.home') }}</a>
                <a href="{{ route('shop') }}"       class="{{ request()->routeIs('shop') || request()->routeIs('product.detail') ? 'active' : '' }}">{{ __('messages.menu.shop') }}</a>
                <a href="{{ route('care.guide') }}" class="{{ request()->routeIs('care.guide') ? 'active' : '' }}">{{ __('messages.menu.care') }}</a>
                <a href="{{ route('blog') }}"       class="{{ request()->routeIs('blog') || request()->routeIs('blog.detail') ? 'active' : '' }}">{{ __('messages.menu.blog') }}</a>
                <a href="{{ route('about') }}"      class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('messages.menu.about') }}</a>
            </nav>

            {{-- Header actions (right) --}}
            <div class="header-actions" style="display:flex;align-items:center;gap:.5rem;">
                <button class="icon-btn" onclick="toggleSearch()"><i class="fas fa-search"></i></button>

                @auth
                <button class="icon-btn" onclick="window.location.href='{{ route('wishlist') }}'">
                    <i class="fas fa-heart"></i>
                    <span class="badge" id="wishlist-badge">{{ $wishlistCount }}</span>
                </button>
                <a href="{{ route('cart') }}" class="icon-btn {{ request()->routeIs('cart') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge" id="cart-badge">{{ $cartCount }}</span>
                </a>
                @else
                <button class="icon-btn" onclick="toggleLoginModal()"><i class="fas fa-heart"></i></button>
                <a href="{{ route('cart') }}" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
                @endauth

                {{-- Language — desktop only --}}
                <div class="language-switcher hide-mobile" style="display:flex;gap:.4rem;align-items:center;">
                    <a href="{{ route('locale.switch','id') }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;padding:0 8px;border-radius:999px;border:1px solid rgba(6,78,59,.2);color:inherit;text-decoration:none;opacity:{{ app()->getLocale()==='id'?'1':'.6' }};font-size:12px;height:28px;">ID</a>
                    <a href="{{ route('locale.switch','en') }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;padding:0 8px;border-radius:999px;border:1px solid rgba(6,78,59,.2);color:inherit;text-decoration:none;opacity:{{ app()->getLocale()==='en'?'1':'.6' }};font-size:12px;height:28px;">EN</a>
                </div>

                {{-- Currency — desktop only --}}
                <div class="hide-mobile" style="position:relative;display:inline-block;">
                    <button onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='block'?'none':'block'"
                        style="display:inline-flex;align-items:center;gap:4px;padding:0 10px;height:28px;border-radius:999px;border:1px solid rgba(6,78,59,.2);background:transparent;font-size:12px;cursor:pointer;font-weight:600;">
                        {{ $currentCurrency }} <i class="fas fa-chevron-down" style="font-size:9px;"></i>
                    </button>
                    <div style="display:none;position:absolute;right:0;top:34px;background:white;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:3000;padding:6px 0;min-width:80px;">
                        @foreach(['IDR','USD','EUR','SGD','MYR','GBP','AUD','JPY'] as $cur)
                        <a href="{{ route('currency.switch',$cur) }}" style="display:block;padding:7px 16px;font-size:13px;text-decoration:none;color:{{ $currentCurrency===$cur?'var(--primary-color)':'#374151' }};font-weight:{{ $currentCurrency===$cur?'700':'400' }};">{{ $cur }}</a>
                        @endforeach
                    </div>
                </div>

                @auth
                <div class="hide-mobile" style="position:relative;">
                    <button class="icon-btn user-toggle" onclick="toggleUserDropdown()"><i class="fas fa-user"></i></button>
                    <div id="user-dropdown" style="display:none;position:absolute;right:0;top:44px;background:white;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.12);min-width:160px;z-index:2000;padding:8px 0;">
                        <div style="padding:8px 16px;font-weight:600;border-bottom:1px solid #eee;">{{ auth()->user()->name }}</div>
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" style="display:block;padding:10px 16px;color:#374151;text-decoration:none;font-size:14px;"><i class="fas fa-tachometer-alt" style="width:20px;"></i> {{ __('messages.header.admin_panel') }}</a>
                        @endif
                        <a href="{{ route('customer.orders.index') }}" style="display:block;padding:10px 16px;color:#374151;text-decoration:none;font-size:14px;"><i class="fas fa-box" style="width:20px;"></i> {{ __('messages.header.order_history') }}</a>
                        <a href="{{ route('cart') }}" style="display:block;padding:10px 16px;color:#374151;text-decoration:none;font-size:14px;"><i class="fas fa-shopping-cart" style="width:20px;"></i> {{ __('messages.cart.title') }}</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 16px;background:none;border:none;color:#374151;font-size:14px;cursor:pointer;"><i class="fas fa-sign-out-alt" style="width:20px;"></i> {{ __('messages.button.logout') }}</button>
                        </form>
                    </div>
                </div>
                @else
                <button class="icon-btn user-toggle hide-mobile" onclick="toggleLoginModal()"><i class="fas fa-user"></i></button>
                @endauth
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         FULLSCREEN MOBILE DRAWER
    ════════════════════════════════════════════════ --}}
    <div id="drawer-backdrop" onclick="toggleDrawer()"
         style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:4000;transition:opacity .3s;"></div>

    <div id="mobile-drawer"
         style="position:fixed;top:0;left:0;bottom:0;width:100%;max-width:100vw;
                background:#fff;z-index:4001;overflow:hidden;
                transform:translateX(-100%);transition:transform .3s cubic-bezier(.4,0,.2,1);
                display:flex;flex-direction:column;">

        {{-- Drawer header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
            <a href="{{ route('home') }}" onclick="toggleDrawer()"
               style="display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--primary-dark);font-size:19px;font-weight:800;">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="height:26px;">
                @else
                    <i class="fas fa-leaf" style="color:var(--secondary-color);font-size:20px;"></i>
                @endif
                {{ $siteName }}
            </a>
            <button onclick="toggleDrawer()"
                style="width:36px;height:36px;border-radius:50%;background:#f1f5f9;border:none;cursor:pointer;
                       display:flex;align-items:center;justify-content:center;font-size:15px;color:#6b7280;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Drawer nav --}}
        <nav style="flex:1;overflow-y:auto;-webkit-overflow-scrolling:touch;">

            <p style="padding:18px 20px 6px;font-size:11px;font-weight:700;letter-spacing:.1em;color:#10b981;text-transform:uppercase;margin:0;">MENU</p>

            @php
            $drawerLinks = [
                ['route' => 'home',       'label' => __('messages.menu.home'),  'active' => request()->routeIs('home')],
                ['route' => 'shop',       'label' => __('messages.menu.shop'),  'active' => request()->routeIs('shop') || request()->routeIs('product.detail')],
                ['route' => 'care.guide', 'label' => __('messages.menu.care'),  'active' => request()->routeIs('care.guide')],
                ['route' => 'blog',       'label' => __('messages.menu.blog'),  'active' => request()->routeIs('blog') || request()->routeIs('blog.detail')],
                ['route' => 'about',      'label' => __('messages.menu.about'), 'active' => request()->routeIs('about')],
                ['route' => 'contact',    'label' => app()->getLocale()==='id'?'Kontak':'Contact', 'active' => request()->routeIs('contact')],
            ];
            @endphp

            @foreach($drawerLinks as $link)
            <a href="{{ route($link['route']) }}" onclick="toggleDrawer()"
               style="display:flex;align-items:center;justify-content:space-between;
                      padding:17px 20px;text-decoration:none;font-size:16px;font-weight:600;
                      color:{{ $link['active']?'#10b981':'#111827' }};
                      border-bottom:1px solid #f8fafb;">
                {{ $link['label'] }}
                <i class="fas fa-chevron-right" style="font-size:11px;color:#d1d5db;"></i>
            </a>
            @endforeach

            {{-- Language --}}
            <p style="padding:18px 20px 6px;font-size:11px;font-weight:700;letter-spacing:.1em;color:#10b981;text-transform:uppercase;margin:0;">{{ app()->getLocale()==='id'?'LAINNYA':'MORE' }}</p>

            <div style="display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid #f8fafb;">
                <span style="font-size:14px;color:#6b7280;font-weight:500;">{{ app()->getLocale()==='id'?'Bahasa':'Language' }}:</span>
                <a href="{{ route('locale.switch','id') }}"
                   style="padding:5px 16px;border-radius:999px;border:1.5px solid {{ app()->getLocale()==='id'?'#10b981':'#e5e7eb' }};background:{{ app()->getLocale()==='id'?'#10b981':'transparent' }};color:{{ app()->getLocale()==='id'?'white':'#374151' }};font-size:13px;font-weight:700;text-decoration:none;">ID</a>
                <a href="{{ route('locale.switch','en') }}"
                   style="padding:5px 16px;border-radius:999px;border:1.5px solid {{ app()->getLocale()==='en'?'#10b981':'#e5e7eb' }};background:{{ app()->getLocale()==='en'?'#10b981':'transparent' }};color:{{ app()->getLocale()==='en'?'white':'#374151' }};font-size:13px;font-weight:700;text-decoration:none;">EN</a>
            </div>

            @auth
            <a href="{{ route('customer.orders.index') }}" onclick="toggleDrawer()"
               style="display:flex;align-items:center;gap:14px;padding:16px 20px;text-decoration:none;font-size:15px;color:#374151;border-bottom:1px solid #f8fafb;">
                <i class="fas fa-box" style="color:#10b981;width:18px;text-align:center;"></i>
                {{ __('messages.header.order_history') }}
            </a>
            @if(auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" onclick="toggleDrawer()"
               style="display:flex;align-items:center;gap:14px;padding:16px 20px;text-decoration:none;font-size:15px;color:#374151;border-bottom:1px solid #f8fafb;">
                <i class="fas fa-tachometer-alt" style="color:#10b981;width:18px;text-align:center;"></i>
                {{ __('messages.header.admin_panel') }}
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="display:flex;align-items:center;gap:14px;width:100%;padding:16px 20px;background:none;border:none;font-size:15px;color:#ef4444;cursor:pointer;font-family:inherit;text-align:left;">
                    <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i>
                    {{ __('messages.button.logout') }}
                </button>
            </form>
            @else
            <button onclick="toggleDrawer();setTimeout(toggleLoginModal,200);"
                style="display:flex;align-items:center;gap:14px;width:100%;padding:16px 20px;background:none;border:none;font-size:15px;color:#374151;cursor:pointer;font-family:inherit;text-align:left;">
                <i class="fas fa-sign-in-alt" style="color:#10b981;width:18px;text-align:center;"></i>
                {{ __('messages.button.login') }}
            </button>
            @endauth
        </nav>

        {{-- Drawer footer --}}
    </div>

    {{-- Search overlay --}}
    <div id="search-overlay" class="search-overlay" style="display:none;">
        <div class="search-container">
            <form action="{{ route('shop') }}" method="GET" style="display:flex;align-items:center;width:100%;">
                <input type="text" name="search" placeholder="{{ __('messages.common.search_placeholder') }}" id="search-input" autocomplete="off">
                <button type="submit" style="background:none;border:none;cursor:pointer;padding:0 12px;color:var(--primary-color);"><i class="fas fa-search"></i></button>
            </form>
            <button onclick="toggleSearch()" class="close-search"><i class="fas fa-times"></i></button>
        </div>
    </div>

    {{-- Login modal --}}
    <div id="login-modal" class="login-modal" style="display:none;">
        <div class="login-modal-backdrop" onclick="toggleLoginModal()"></div>
        <div class="login-modal-card">
            <button class="login-modal-close" onclick="toggleLoginModal()"><i class="fas fa-times"></i></button>
            <h2>{{ __('messages.header.login_title') }}</h2>
            <p>{{ __('messages.header.login_desc') }}</p>
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <label>{{ __('messages.header.email') }}<input type="email" name="email" placeholder="email@example.com" required></label>
                <label>{{ __('messages.header.password') }}<input type="password" name="password" placeholder="{{ __('messages.header.password') }}" required></label>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                    <input type="checkbox" name="remember" id="remember-modal" style="width:16px;height:16px;">
                    <label for="remember-modal" style="font-size:13px;color:#4b5563;cursor:pointer;margin:0;">{{ __('messages.header.remember_me') }}</label>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.button.login') }}</button>
            </form>
            <div style="display:flex;align-items:center;gap:12px;margin:18px 0;">
                <div style="flex:1;height:1px;background:#e5e7eb;"></div>
                <span style="font-size:12px;font-weight:700;color:#6b7280;">{{ __('messages.header.or') }}</span>
                <div style="flex:1;height:1px;background:#e5e7eb;"></div>
            </div>
            <a href="{{ route('auth.google') }}" style="display:flex;align-items:center;justify-content:center;gap:12px;width:100%;padding:14px 16px;border:1px solid #d1d5db;border-radius:14px;color:#111827;font-weight:600;text-decoration:none;margin-bottom:12px;">
                <span style="display:inline-flex;width:22px;height:22px;border-radius:50%;align-items:center;justify-content:center;background:#fff;color:#ea4335;border:1px solid #e5e7eb;font-size:13px;font-weight:700;">G</span>
                {{ __('messages.header.login_google') }}
            </a>
            <p class="login-modal-note">{{ __('messages.header.no_account') }} <a href="{{ route('register') }}">{{ __('messages.header.register_here') }}</a></p>
        </div>
    </div>

    <style>
    /* ── Mobile header adjustments ───────────────────── */
    @media (max-width: 992px) {
        .header-wrapper {
            position: relative;
        }
        /* Logo centered on mobile */
        .header-wrapper > .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        /* Show hamburger */
        .mobile-menu-btn { display: inline-flex !important; }
        /* Hide desktop nav */
        #desktop-nav { display: none !important; }
        /* Hide language, currency, user on mobile (in drawer) */
        .hide-mobile { display: none !important; }
    }

    /* Login modal */
    .login-modal { position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:5000;display:flex;align-items:center;justify-content:center;padding:1.5rem; }
    .login-modal-backdrop { position:absolute;inset:0; }
    .login-modal-card { position:relative;z-index:1;width:min(100%,420px);background:#fff;border-radius:24px;padding:2rem;box-shadow:0 32px 80px rgba(15,23,42,.15);text-align:center; }
    .login-modal-card h2 { margin-bottom:.75rem;font-size:1.6rem;color:#15332a; }
    .login-modal-card p { margin-bottom:1rem;color:#4b5563;line-height:1.6; }
    .login-form { display:grid;gap:1rem;margin-bottom:1rem; }
    .login-form label { display:grid;gap:.5rem;text-align:left;font-size:.95rem;color:#374151; }
    .login-form input[type=email],.login-form input[type=password] { width:100%;padding:.9rem 1rem;border:1px solid #d1d5db;border-radius:18px;background:#f8fafc;font-size:.95rem;color:#0f172a; }
    .login-form input:focus { outline:none;border-color:#10b981;box-shadow:0 0 0 4px rgba(16,185,129,.12); }
    .login-modal-close { position:absolute;top:16px;right:16px;border:none;background:transparent;color:#374151;font-size:1rem;cursor:pointer; }
    .login-modal-note { margin:1rem 0 0;color:#475569;font-size:.95rem; }
    .login-modal-note a { color:#10708f;text-decoration:underline; }
    .btn { display:inline-flex;align-items:center;justify-content:center;min-width:140px;width:auto;gap:.5rem;padding:.85rem 1rem;border-radius:999px;border:none;font-weight:600;cursor:pointer;transition:transform .15s ease;text-decoration:none;color:white; }
    .btn:hover { transform:translateY(-1px); }
    .btn-primary { background:#1f7a5d; }
    </style>
</header>

@push('scripts')
<script>
// ── Drawer ────────────────────────────────────────────
function toggleDrawer() {
    const drawer   = document.getElementById('mobile-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    const bottomNav = document.getElementById('bottom-nav');
    const isOpen   = drawer.style.transform === 'translateX(0px)' || drawer.style.transform === 'translateX(0%)';

    if (isOpen) {
        drawer.style.transform   = 'translateX(-100%)';
        backdrop.style.display   = 'none';
        document.body.style.overflow = '';
        if (bottomNav) bottomNav.style.display = '';
    } else {
        backdrop.style.display   = 'block';
        drawer.style.transform   = 'translateX(0%)';
        document.body.style.overflow = 'hidden';
        if (bottomNav) bottomNav.style.display = 'none';
    }
}

// ── Search ────────────────────────────────────────────
function toggleSearch() {
    const overlay = document.getElementById('search-overlay');
    overlay.style.display = overlay.style.display === 'none' ? 'flex' : 'none';
    if (overlay.style.display === 'flex') document.getElementById('search-input').focus();
}

// ── Login modal ───────────────────────────────────────
function toggleLoginModal() {
    const modal = document.getElementById('login-modal');
    if (!modal) return;
    modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    document.body.style.overflow = modal.style.display === 'flex' ? 'hidden' : '';
}

// ── User dropdown (desktop) ───────────────────────────
function toggleUserDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    if (dropdown) dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('user-dropdown');
    const toggle   = document.querySelector('.user-toggle');
    if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});

// Close drawer on resize to desktop
window.addEventListener('resize', function() {
    if (window.innerWidth > 992) {
        const drawer    = document.getElementById('mobile-drawer');
        const backdrop  = document.getElementById('drawer-backdrop');
        const bottomNav = document.getElementById('bottom-nav');
        if (drawer)   drawer.style.transform = 'translateX(-100%)';
        if (backdrop) backdrop.style.display = 'none';
        if (bottomNav) bottomNav.style.display = '';
        document.body.style.overflow = '';
    }
});
</script>
@endpush
