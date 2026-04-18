@php
use App\Models\Setting;
$siteName  = Setting::get('site_name', 'LongLeaf');
$siteLogo  = Setting::get('site_logo', '');
$address   = Setting::get('contact_address', 'Jl. Tanaman Indah No. 123, Jakarta');
$phone     = Setting::get('contact_phone', '+62 812 3456 7890');
$whatsapp  = Setting::get('contact_whatsapp', '+62 812 3456 7890');
$email     = Setting::get('contact_email', 'hello@greenhaven.id');
$hours     = Setting::get('contact_hours', 'Senin - Sabtu, 08:00 - 18:00 WIB');
$facebook  = Setting::get('social_facebook', '');
$instagram = Setting::get('social_instagram', '');
$twitter   = Setting::get('social_twitter', '');
$youtube   = Setting::get('social_youtube', '');
$tiktok    = Setting::get('social_tiktok', '');
@endphp

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-about">
                <a href="{{ route('home') }}" class="logo">
                    @if($siteLogo)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="height:28px;margin-right:8px;">
                    @else
                        <i class="fas fa-leaf"></i>
                    @endif
                    <span>{{ $siteName }}</span>
                </a>
                <p>{{ __('messages.footer.description') }}</p>
                <div class="social-links">
                    @if($facebook)  <a href="{{ $facebook }}"  target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                    @if($instagram) <a href="{{ $instagram }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>@endif
                    @if($twitter)   <a href="{{ $twitter }}"   target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>@endif
                    @if($youtube)   <a href="{{ $youtube }}"   target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>@endif
                    @if($tiktok)    <a href="{{ $tiktok }}"    target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>@endif
                    {{-- Fallback jika semua kosong --}}
                    @if(!$facebook && !$instagram && !$twitter && !$youtube && !$tiktok)
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>
            <div class="footer-links">
                <h4>{{ __('messages.footer.categories') }}</h4>
                <ul>
                    <li><a href="{{ route('category.indoor') }}">{{ __('messages.shop.indoor') }}</a></li>
                    <li><a href="{{ route('category.outdoor') }}">{{ __('messages.shop.outdoor') }}</a></li>
                    <li><a href="{{ route('category.succulent') }}">{{ __('messages.shop.succulent') }}</a></li>
                    <li><a href="{{ route('category.rare') }}">{{ __('messages.shop.rare') }}</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>{{ __('messages.footer.help') }}</h4>
                <ul>
                    <li><a href="{{ route('care.guide') }}">{{ __('messages.footer.care_guide') }}</a></li>
                    <li><a href="#">{{ __('messages.footer.shipping') }}</a></li>
                    <li><a href="#">{{ __('messages.footer.returns') }}</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact_us') }}</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>{{ __('messages.footer.contact') }}</h4>
                @if($address)   <p><i class="fas fa-map-marker-alt"></i> {!! nl2br(e($address)) !!}</p>@endif
                @if($phone)     <p><i class="fas fa-phone"></i> {{ $phone }}</p>@endif
                @if($email)     <p><i class="fas fa-envelope"></i> {{ $email }}</p>@endif
                @if($whatsapp)  <p><i class="fab fa-whatsapp"></i> {{ $whatsapp }}</p>@endif
                @if($hours)     <p><i class="fas fa-clock"></i> {{ $hours }}</p>@endif
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('messages.footer.copyright') }}</p>
        </div>
    </div>
</footer>
