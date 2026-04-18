<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo      = $seo ?? null;
        $siteName = App\Models\Setting::get('site_name', 'GreenHaven');
        $seoTitle = $seo?->title ?? (View::yieldContent('title') ?: $siteName . ' — Toko Tanaman Online');
        $seoDesc  = $seo?->description ?? 'Temukan koleksi tanaman hias terbaik untuk mempercantik rumah Anda. Pengiriman aman ke seluruh Indonesia.';
        $seoImg   = $seo?->image ?? (App\Models\Setting::get('site_logo') ?: config('app.url') . '/images/og-default.jpg');
        $seoUrl   = $seo?->url ?? request()->url();
        $seoType  = $seo?->type ?? 'website';
    @endphp

    <title>@yield('title', $siteName . ' — Toko Tanaman Online')</title>

    {{-- Core SEO --}}
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $seoUrl }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="{{ $seoType }}">
    <meta property="og:title"       content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:image"       content="{{ $seoImg }}">
    <meta property="og:url"         content="{{ $seoUrl }}">
    <meta property="og:site_name"   content="{{ $siteName }}">
    <meta property="og:locale"      content="{{ app()->getLocale() === 'id' ? 'id_ID' : 'en_US' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image"       content="{{ $seoImg }}">

    {{-- JSON-LD Schema --}}
    @if($seo?->schema)
    <script type="application/ld+json">{!! json_encode($seo->schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @endif

    {{-- Organization schema on every page --}}
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => $siteName,
        'url'      => config('app.url'),
        'logo'     => App\Models\Setting::get('site_logo', ''),
        'contactPoint' => [
            '@type'       => 'ContactPoint',
            'telephone'   => App\Models\Setting::get('contact_phone', ''),
            'contactType' => 'customer service',
        ],
        'sameAs' => array_filter([
            App\Models\Setting::get('social_facebook', ''),
            App\Models\Setting::get('social_instagram', ''),
            App\Models\Setting::get('social_twitter', ''),
            App\Models\Setting::get('social_youtube', ''),
        ]),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plant-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive-fix.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')

    @include('partials.mobile-bottom-nav')

    @include('partials.ai-chat-bubble', [
        'productId'   => $aiProductId   ?? null,
        'productName' => $aiProductName ?? null,
    ])
    
    <!-- Toast Notification -->
    <div id="toast" class="toast-notification" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span id="toast-message"></span>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // CSRF Token for AJAX
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    
    @stack('scripts')
</body>
</html>
