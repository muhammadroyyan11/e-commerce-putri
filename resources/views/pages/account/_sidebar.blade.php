@php $active = $active ?? 'profile'; @endphp

<aside style="background:white;border-radius:20px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.05);position:sticky;top:92px;">
    <div style="text-align:center;padding-bottom:18px;border-bottom:1px solid #f1f5f9;margin-bottom:14px;">
        <div style="width:64px;height:64px;border-radius:50%;background:var(--gradient-primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:22px;margin:0 auto 10px;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <p style="font-weight:700;font-size:14px;color:#111827;margin:0 0 2px;">{{ auth()->user()->name }}</p>
        <p style="font-size:12px;color:#9ca3af;margin:0;">{{ auth()->user()->email }}</p>
    </div>

    <nav style="display:flex;flex-direction:column;gap:4px;">
        <a href="{{ route('account.profile') }}"
           class="acc-nav-item {{ $active === 'profile' ? 'acc-nav-item--active' : '' }}">
            <i class="fas fa-user"></i>
            <span>{{ __('messages.account.profile_tab') }}</span>
        </a>
        <a href="{{ route('account.addresses') }}"
           class="acc-nav-item {{ $active === 'addresses' ? 'acc-nav-item--active' : '' }}">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ __('messages.account.address_tab') }}</span>
        </a>
        <a href="{{ route('customer.orders.index') }}"
           class="acc-nav-item {{ $active === 'orders' ? 'acc-nav-item--active' : '' }}">
            <i class="fas fa-box"></i>
            <span>{{ __('messages.account.orders_tab') }}</span>
        </a>
        <a href="{{ route('wishlist') }}"
           class="acc-nav-item {{ $active === 'wishlist' ? 'acc-nav-item--active' : '' }}">
            <i class="fas fa-heart"></i>
            <span>{{ __('messages.wishlist.title') }}</span>
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;padding-top:14px;border-top:1px solid #f1f5f9;">
        @csrf
        <button type="submit" class="acc-nav-item" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit;color:#ef4444;">
            <i class="fas fa-sign-out-alt"></i>
            <span>{{ __('messages.button.logout') }}</span>
        </button>
    </form>
</aside>
