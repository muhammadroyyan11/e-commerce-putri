@php
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Setting;

$siteName = Setting::get('site_name', 'LongLeaf');
$siteLogo = Setting::get('site_logo', '');
$cartCount = auth()->check() ? Cart::where('user_id', auth()->id())->count() : 0;
$wishlistCount = auth()->check() ? Wishlist::where('user_id', auth()->id())->count() : 0;
@endphp

<header class="header">
    <div class="container">
        <div class="header-wrapper">
            <a href="{{ route('home') }}" class="logo">
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="height: 32px; margin-right: 8px;">
                @else
                    <i class="fas fa-leaf"></i>
                @endif
                <span>{{ $siteName }}</span>
            </a>
            <nav class="nav-menu">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.menu.home') }}</a>
                <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') || request()->routeIs('product.detail') ? 'active' : '' }}">{{ __('messages.menu.shop') }}</a>
                <a href="{{ route('care.guide') }}" class="{{ request()->routeIs('care.guide') ? 'active' : '' }}">{{ __('messages.menu.care') }}</a>
                <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') || request()->routeIs('blog.detail') ? 'active' : '' }}">{{ __('messages.menu.blog') }}</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('messages.menu.about') }}</a>

                <div class="language-switcher-mobile" style="display: none;">
                    <span style="font-size: 14px; color: var(--text-muted);">{{ __('messages.common.language') }}:</span>
                    <a href="{{ route('locale.switch', 'id') }}" style="padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border-color); text-decoration: none; font-size: 13px; {{ app()->getLocale() === 'id' ? 'background: var(--primary-color); color: white; border-color: var(--primary-color);' : 'color: var(--text-medium);' }}">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}" style="padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border-color); text-decoration: none; font-size: 13px; {{ app()->getLocale() === 'en' ? 'background: var(--primary-color); color: white; border-color: var(--primary-color);' : 'color: var(--text-medium);' }}">EN</a>
                </div>
            </nav>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()" aria-label="Toggle navigation">
                <i class="fas fa-bars" id="menu-icon"></i>
            </button>

            <div id="mobile-menu-overlay" class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 0.5rem;">
                <button class="icon-btn search-toggle" onclick="toggleSearch()">
                    <i class="fas fa-search"></i>
                </button>
                @auth
                <button class="icon-btn wishlist-toggle" onclick="window.location.href='{{ route('wishlist') }}'">
                    <i class="fas fa-heart"></i>
                    <span class="badge" id="wishlist-badge">{{ $wishlistCount }}</span>
                </button>
                <a href="{{ route('cart') }}" class="icon-btn cart-toggle {{ request()->routeIs('cart') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge" id="cart-badge">{{ $cartCount }}</span>
                </a>
                @else
                <button class="icon-btn wishlist-toggle" onclick="toggleLoginModal()">
                    <i class="fas fa-heart"></i>
                </button>
                <a href="{{ route('cart') }}" class="icon-btn cart-toggle {{ request()->routeIs('cart') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                @endauth
                <div class="language-switcher" style="display: flex; gap: 0.4rem; align-items: center;">
                    <a href="{{ route('locale.switch', 'id') }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 32px; padding: 0 8px; border-radius: 999px; border: 1px solid rgba(6, 78, 59, 0.2); color: inherit; text-decoration: none; opacity: {{ app()->getLocale() === 'id' ? '1' : '0.6' }}; font-size: 12px; height: 28px;">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 32px; padding: 0 8px; border-radius: 999px; border: 1px solid rgba(6, 78, 59, 0.2); color: inherit; text-decoration: none; opacity: {{ app()->getLocale() === 'en' ? '1' : '0.6' }}; font-size: 12px; height: 28px;">EN</a>
                </div>
                {{-- Currency Switcher --}}
                <div style="position:relative; display:inline-block;">
                    <button onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='block'?'none':'block'"
                        style="display:inline-flex; align-items:center; gap:4px; padding:0 10px; height:28px; border-radius:999px; border:1px solid rgba(6,78,59,0.2); background:transparent; font-size:12px; cursor:pointer; font-weight:600;">
                        {{ $currentCurrency }} <i class="fas fa-chevron-down" style="font-size:9px;"></i>
                    </button>
                    <div style="display:none; position:absolute; right:0; top:34px; background:white; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:3000; padding:6px 0; min-width:80px;">
                        @foreach(['IDR','USD','EUR','SGD','MYR','GBP','AUD','JPY'] as $cur)
                        <a href="{{ route('currency.switch', $cur) }}"
                            style="display:block; padding:7px 16px; font-size:13px; text-decoration:none; color:{{ $currentCurrency === $cur ? 'var(--primary-color)' : '#374151' }}; font-weight:{{ $currentCurrency === $cur ? '700' : '400' }};">
                            {{ $cur }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @auth
                <div class="dropdown" style="position: relative;">
                    <button class="icon-btn user-toggle" onclick="toggleUserDropdown()">
                        <i class="fas fa-user"></i>
                    </button>
                    <div id="user-dropdown" style="display: none; position: absolute; right: 0; top: 44px; background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 160px; z-index: 2000; padding: 8px 0;">
                        <div style="padding: 8px 16px; font-weight: 600; border-bottom: 1px solid #eee;">{{ auth()->user()->name }}</div>
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none; font-size: 14px;"><i class="fas fa-tachometer-alt" style="width: 20px;"></i> {{ __('messages.header.admin_panel') }}</a>
                        @endif
                        <a href="{{ route('customer.orders.index') }}" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none; font-size: 14px;"><i class="fas fa-box" style="width: 20px;"></i> {{ __('messages.header.order_history') }}</a>
                        <a href="{{ route('cart') }}" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none; font-size: 14px;"><i class="fas fa-shopping-cart" style="width: 20px;"></i> {{ __('messages.cart.title') }}</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 16px; background: none; border: none; color: #374151; font-size: 14px; cursor: pointer;"><i class="fas fa-sign-out-alt" style="width: 20px;"></i> {{ __('messages.button.logout') }}</button>
                        </form>
                    </div>
                </div>
                @else
                <button class="icon-btn user-toggle" onclick="toggleLoginModal()">
                    <i class="fas fa-user"></i>
                </button>
                @endauth
            </div>
        </div>
    </div>

    <div id="search-overlay" class="search-overlay" style="display: none;">
        <div class="search-container">
            <form action="{{ route('shop') }}" method="GET" style="display:flex; align-items:center; width:100%;">
                <input type="text" name="search" placeholder="{{ __('messages.common.search_placeholder') }}" id="search-input" autocomplete="off">
                <button type="submit" style="background:none; border:none; cursor:pointer; padding:0 12px; color:var(--primary-color);">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <button onclick="toggleSearch()" class="close-search">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div id="login-modal" class="login-modal" style="display: none;">
        <div class="login-modal-backdrop" onclick="toggleLoginModal()"></div>
        <div class="login-modal-card">
            <button class="login-modal-close" onclick="toggleLoginModal()" aria-label="Close login modal">
                <i class="fas fa-times"></i>
            </button>
            <h2>{{ __('messages.header.login_title') }}</h2>
            <p>{{ __('messages.header.login_desc') }}</p>
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <label>
                    {{ __('messages.header.email') }}
                    <input type="email" name="email" placeholder="email@example.com" required>
                </label>
                <label>
                    {{ __('messages.header.password') }}
                    <input type="password" name="password" placeholder="{{ __('messages.header.password') }}" required>
                </label>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                    <input type="checkbox" name="remember" id="remember-modal" style="width: 16px; height: 16px;">
                    <label for="remember-modal" style="font-size: 13px; color: #4b5563; cursor: pointer; margin: 0;">{{ __('messages.header.remember_me') }}</label>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.button.login') }}</button>
            </form>
            <div style="display: flex; align-items: center; gap: 12px; margin: 18px 0;">
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                <span style="font-size: 12px; font-weight: 700; letter-spacing: 0.08em; color: #6b7280;">{{ __('messages.header.or') }}</span>
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
            </div>
            <a href="{{ route('auth.google') }}" style="display: flex; align-items: center; justify-content: center; gap: 12px; width: 100%; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 14px; color: #111827; font-weight: 600; text-decoration: none; margin-bottom: 12px;">
                <span style="display: inline-flex; width: 22px; height: 22px; border-radius: 50%; align-items: center; justify-content: center; background: #fff; color: #ea4335; border: 1px solid #e5e7eb; font-size: 13px; font-weight: 700;">G</span>
                {{ __('messages.header.login_google') }}
            </a>
            <p class="login-modal-note">
                {{ __('messages.header.no_account') }}
                <a href="{{ route('register') }}">{{ __('messages.header.register_here') }}</a>
            </p>
        </div>
    </div>

    <style>
        .login-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 3000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.65);
        }
        .login-modal-card {
            position: relative;
            z-index: 1;
            width: min(100%, 420px);
            background: #fff;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 32px 80px rgba(15, 23, 42, 0.15);
            text-align: center;
        }
        .login-modal-card h2 {
            margin-bottom: 0.75rem;
            font-size: 1.6rem;
            color: #15332a;
        }
        .login-modal-card p {
            margin-bottom: 1rem;
            color: #4b5563;
            line-height: 1.6;
        }
        .login-form {
            display: grid;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .login-form label {
            display: grid;
            gap: 0.5rem;
            text-align: left;
            font-size: 0.95rem;
            color: #374151;
        }
        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 18px;
            background: #f8fafc;
            font-size: 0.95rem;
            color: #0f172a;
        }
        .login-form input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
        }
        .login-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            border: none;
            background: transparent;
            color: #374151;
            font-size: 1rem;
            cursor: pointer;
        }
        .login-modal-note {
            margin: 1rem 0 0;
            color: #475569;
            font-size: 0.95rem;
        }
        .login-modal-note a {
            color: #10708f;
            text-decoration: underline;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            width: auto;
            gap: 0.5rem;
            padding: 0.85rem 1rem;
            border-radius: 999px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, background-color 0.15s ease;
            text-decoration: none;
            color: white;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: #1f7a5d;
        }
    </style>
</header>

@push('scripts')
<script>
    function toggleSearch() {
        const overlay = document.getElementById('search-overlay');
        overlay.style.display = overlay.style.display === 'none' ? 'flex' : 'none';
        if (overlay.style.display === 'flex') {
            document.getElementById('search-input').focus();
        }
    }

    function toggleMobileMenu() {
        const menu = document.querySelector('.nav-menu');
        const overlay = document.getElementById('mobile-menu-overlay');
        const icon = document.getElementById('menu-icon');
        if (!menu) return;

        const isOpen = menu.classList.toggle('show');
        overlay.classList.toggle('show', isOpen);

        if (isOpen) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
            document.body.style.overflow = 'hidden';
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            document.body.style.overflow = '';
        }
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            const menu = document.querySelector('.nav-menu');
            const overlay = document.getElementById('mobile-menu-overlay');
            const icon = document.getElementById('menu-icon');
            if (menu && menu.classList.contains('show')) {
                menu.classList.remove('show');
                overlay.classList.remove('show');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                document.body.style.overflow = '';
            }
        }
    });

    function toggleLoginModal() {
        const modal = document.getElementById('login-modal');
        if (!modal) return;
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        document.body.style.overflow = modal.style.display === 'flex' ? 'hidden' : '';
    }

    function toggleUserDropdown() {
        const dropdown = document.getElementById('user-dropdown');
        if (!dropdown) return;
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('user-dropdown');
        const toggle = document.querySelector('.user-toggle');
        if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>
@endpush
