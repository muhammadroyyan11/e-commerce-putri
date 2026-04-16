@php
use App\Models\Setting;
$siteName = Setting::get('site_name', 'LongLeaf');
@endphp

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-about">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-leaf"></i>
                    <span>{{ $siteName }}</span>
                </a>
                <p>{{ __('messages.footer.description') }}</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>{{ __('messages.footer.categories') }}</h4>
                <ul>
                    <li><a href="{{ route('category.indoor') }}">{{ __('messages.shop.indoor') }}</a></li>
                    <li><a href="{{ route('category.outdoor') }}">{{ __('messages.shop.outdoor') }}</a></li>
                    <li><a href="{{ route('category.succulent') }}">{{ __('messages.shop.succulent') }}</a></li>
                    <li><a href="{{ route('category.rare') }}">{{ __('messages.shop.rare') }}</a></li>
                    <li><a href="{{ route('shop') }}">Pot & Accessories</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>{{ __('messages.footer.help') }}</h4>
                <ul>
                    <li><a href="{{ route('care.guide') }}">{{ __('messages.footer.care_guide') }}</a></li>
                    <li><a href="#">{{ __('messages.footer.shipping') }}</a></li>
                    <li><a href="#">{{ __('messages.footer.returns') }}</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact_us') }}</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>{{ __('messages.footer.contact') }}</h4>
                <p><i class="fas fa-map-marker-alt"></i> {{ __('messages.footer.address') }}</p>
                <p><i class="fas fa-phone"></i> {{ __('messages.footer.phone') }}</p>
                <p><i class="fas fa-envelope"></i> hello@LongLeaf.id</p>
                <p><i class="fab fa-whatsapp"></i> {{ __('messages.footer.whatsapp') }}</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('messages.footer.copyright') }}</p>
        </div>
    </div>
</footer>
