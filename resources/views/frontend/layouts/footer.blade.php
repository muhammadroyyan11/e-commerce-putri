{{-- ===== ORGANIK FOOTER ===== --}}
@php
    $settings_footer = DB::table('settings')->first();
@endphp

<footer class="organik-footer">
    <div class="container">
        <div class="row g-4 pb-4">

            {{-- Brand Info --}}
            <div class="col-md-4">
                <h6>{{ $settings_footer->name ?? config('app.name') }}</h6>
                <p class="small mb-3">{{ $settings_footer->short_des ?? 'Quality products delivered to your doorstep with care and speed.' }}</p>
                @if($settings_footer && $settings_footer->phone)
                <p class="small mb-1"><i class="fas fa-phone-alt me-2"></i>{{ $settings_footer->phone }}</p>
                @endif
                @if($settings_footer && $settings_footer->email)
                <p class="small mb-1"><i class="fas fa-envelope me-2"></i>{{ $settings_footer->email }}</p>
                @endif
                @if($settings_footer && $settings_footer->address)
                <p class="small"><i class="fas fa-map-marker-alt me-2"></i>{{ $settings_footer->address }}</p>
                @endif
            </div>

            {{-- Information --}}
            <div class="col-md-2 col-6">
                <h6>Information</h6>
                <a href="{{ route('about-us') }}">About Us</a>
                <a href="{{ route('blog') }}">Blog</a>
                <a href="{{ route('contact') }}">Contact Us</a>
                <a href="#">FAQ</a>
            </div>

            {{-- Customer Service --}}
            <div class="col-md-2 col-6">
                <h6>Customer Service</h6>
                <a href="#">Payment Methods</a>
                <a href="#">Returns</a>
                <a href="{{ route('order.track') }}">Track Order</a>
                <a href="#">Privacy Policy</a>
            </div>

            {{-- Account --}}
            <div class="col-md-2 col-6">
                <h6>My Account</h6>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin') }}">Admin Panel</a>
                    @else
                        <a href="{{ route('user') }}">Dashboard</a>
                        <a href="{{ route('user.order.index') }}">My Orders</a>
                        <a href="{{ route('user-profile') }}">Profile</a>
                    @endif
                    <a href="{{ route('user.logout') }}">Logout</a>
                @else
                    <a href="{{ route('login.form') }}">Login</a>
                    <a href="{{ route('register.form') }}">Register</a>
                @endauth
            </div>

            {{-- Shop --}}
            <div class="col-md-2 col-6">
                <h6>Shop</h6>
                <a href="{{ route('product-grids') }}">All Products</a>
                <a href="{{ route('wishlist') }}">Wishlist</a>
                <a href="{{ route('cart') }}">Cart</a>
                @auth
                    <a href="{{ route('checkout') }}">Checkout</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; {{ date('Y') }} {{ $settings_footer->name ?? config('app.name') }}. All rights reserved.
    </div>
</footer>
{{-- ===== END FOOTER ===== --}}

{{-- ===== SCRIPTS ===== --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

{{-- Keep existing frontend JS for features that rely on it --}}
<script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
<script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
<script src="{{ asset('frontend/js/colors.js') }}"></script>
<script src="{{ asset('frontend/js/active.js') }}"></script>

<script>
    // Auto-dismiss alerts after 5s
    setTimeout(function() { $('.alert').slideUp(400); }, 5000);
</script>

@stack('scripts')