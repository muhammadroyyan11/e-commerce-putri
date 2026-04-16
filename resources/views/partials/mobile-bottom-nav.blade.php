@php
$cartCount = auth()->check() ? App\Models\Cart::where('user_id', auth()->id())->count() : 0;
$isHome    = request()->routeIs('home');
$isShop    = request()->routeIs('shop') || request()->routeIs('product.detail') || request()->routeIs('category.*');
$isCart    = request()->routeIs('cart');
$isAccount = request()->routeIs('customer.orders.*') || request()->routeIs('wishlist');
$isId      = app()->getLocale() === 'id';
@endphp

<nav id="bottom-nav">

    {{-- Home --}}
    <a href="{{ route('home') }}" class="bni {{ $isHome ? 'bni--active' : '' }}">
        <svg class="bni__svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>{{ $isId ? 'Beranda' : 'Home' }}</span>
    </a>

    {{-- Shop --}}
    <a href="{{ route('shop') }}" class="bni {{ $isShop ? 'bni--active' : '' }}">
        <svg class="bni__svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
        <span>{{ $isId ? 'Toko' : 'Shop' }}</span>
    </a>

    {{-- Cart — same style as others --}}
    @auth
        <a href="{{ route('cart') }}" class="bni bni--cart {{ $isCart ? 'bni--cart-active' : '' }}">
            <span class="bni__cart-wrap">
                @if($cartCount > 0)
                    <span class="bni__badge">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                @endif
                <svg class="bni__cart-svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
            </span>
            <span>Cart</span>
        </a>
    @else
        <button onclick="toggleLoginModal()" class="bni bni--cart">
            <span class="bni__cart-wrap">
                <svg class="bni__cart-svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
            </span>
            <span>Cart</span>
        </button>
    @endauth

    {{-- Account --}}
    @auth
        <a href="{{ route('customer.orders.index') }}" class="bni {{ $isAccount ? 'bni--active' : '' }}">
            <svg class="bni__svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>{{ $isId ? 'Akun' : 'Account' }}</span>
        </a>
    @else
        <button onclick="toggleLoginModal()" class="bni">
            <svg class="bni__svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>{{ $isId ? 'Akun' : 'Account' }}</span>
        </button>
    @endauth

</nav>

<style>
#bottom-nav { display: none; }

@media (max-width: 992px) {

    /* ── bar itself ─────────────────────────────────── */
    #bottom-nav {
        display:          flex;
        position:         fixed;
        bottom:           0;
        left:             0;
        right:            0;
        z-index:          1200;
        height:           62px;
        padding-bottom:   env(safe-area-inset-bottom, 0px);
        background:       #fff;
        border-top:       1px solid #e8f5e9;
        box-shadow:       0 -2px 16px rgba(0,0,0,.07);
        align-items:      stretch;
        justify-content:  stretch;
    }

    /* Give page room */
    body { padding-bottom: calc(62px + env(safe-area-inset-bottom, 0px)); }

    /* ── each tab ───────────────────────────────────── */
    .bni {
        flex:           1;
        display:        flex;
        flex-direction: column;
        align-items:    center;
        justify-content:center;
        gap:            3px;
        color:          #9ca3af;
        font-size:      10px;
        font-weight:    600;
        font-family:    inherit;
        text-decoration:none;
        background:     none;
        border:         none;
        cursor:         pointer;
        transition:     color .18s;
        padding:        0;
        letter-spacing: .01em;
    }

    .bni__svg {
        width:  22px;
        height: 22px;
        transition: stroke .18s;
    }

    .bni--active,
    .bni:active { color: #10b981; }
    .bni--active .bni__svg { stroke: #10b981; stroke-width: 2.2; }

    /* ── cart centre tab ────────────────────────────── */
    .bni--cart {
        color: #9ca3af;
    }
    .bni--cart.bni--cart-active,
    .bni--cart:active {
        color: #10b981;
    }
    .bni--cart.bni--cart-active .bni__cart-svg {
        stroke: #10b981;
        stroke-width: 2.2;
    }

    .bni__cart-wrap {
        width:    22px;
        height:   22px;
        display:  flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
    }

    .bni__cart-svg {
        width:  22px;
        height: 22px;
        stroke: currentColor;
        transition: stroke .18s;
    }

    /* badge */
    .bni__badge {
        position:      absolute;
        top:           -5px;
        right:         -6px;
        min-width:     15px;
        height:        15px;
        padding:       0 3px;
        background:    #ef4444;
        color:         #fff;
        font-size:     8px;
        font-weight:   700;
        border-radius: 999px;
        display:       flex;
        align-items:   center;
        justify-content: center;
        border:        2px solid #fff;
    }

    /* ── active pill indicator ──────────────────────── */
    .bni--active::after {
        content:       '';
        position:      absolute;
        bottom:        5px;
        width:         4px;
        height:        4px;
        border-radius: 50%;
        background:    #10b981;
    }
}
</style>
