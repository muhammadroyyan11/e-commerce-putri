{{-- Organik Template Head --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('meta')
<title>@yield('title')</title>

{{-- Favicon --}}
<link rel="icon" type="image/png" href="{{ asset('frontend/images/logo.png') }}">

{{-- Google Fonts: Organik Template --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

{{-- Bootstrap 5 --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

{{-- Swiper --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

{{-- Font Awesome 6 --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Organik Template CSS --}}
<link rel="stylesheet" href="{{ asset('template-organik/css/vendor.css') }}">
<link rel="stylesheet" href="{{ asset('template-organik/style.css') }}">

<style>
    :root {
        --primary-green: #4caf50;
        --dark-green: #1b5e20;
        --light-green: #e8f5e9;
        --accent: #ff9800;
    }
    body {
        font-family: 'Open Sans', sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background: #fafafa;
    }
    main.main-content { flex: 1; }
    h1,h2,h3,h4,h5,h6 { font-family: 'Nunito', sans-serif; }

    /* ======= HEADER ======= */
    .organik-header {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,.07);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .topbar-organik {
        background: var(--dark-green);
        color: rgba(255,255,255,.85);
        font-size: .8rem;
        padding: 5px 0;
    }
    .topbar-organik a { color: rgba(255,255,255,.8); text-decoration: none; }
    .topbar-organik a:hover { color: #fff; }

    .header-logo img { height: 44px; object-fit: contain; }
    .header-logo span { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1.2rem; color: var(--primary-green); }

    .search-wrap {
        background: #f3f4f6;
        border-radius: 30px;
        display: flex;
        align-items: center;
        padding: 6px 16px;
        border: 1px solid #e5e7eb;
    }
    .search-wrap:focus-within { border-color: var(--primary-green); }
    .search-wrap input { border: none; background: transparent; outline: none; flex: 1; font-size: .88rem; }
    .search-wrap button { border: none; background: transparent; color: #888; padding: 0 4px; }
    .search-wrap select { border: none; background: transparent; outline: none; font-size: .82rem; color: #555; border-right: 1px solid #ddd; margin-right: 10px; padding-right: 8px; }

    .header-actions a { color: #444; text-decoration: none; padding: 6px; position: relative; }
    .header-actions a:hover { color: var(--primary-green); }
    .header-actions .badge-count {
        position: absolute; top: 0; right: 0;
        background: #ef5350; color: #fff; border-radius: 50%;
        font-size: .6rem; width: 16px; height: 16px;
        display: flex; align-items: center; justify-content: center;
    }

    .cat-nav-strip {
        border-top: 1px solid #f0f0f0;
        background: #fff;
    }
    .cat-nav-strip .nav-link {
        font-size: .82rem; font-weight: 600;
        color: #555; padding: 8px 14px; white-space: nowrap;
    }
    .cat-nav-strip .nav-link:hover,
    .cat-nav-strip .nav-link.active { color: var(--primary-green); }

    /* ======= FOOTER ======= */
    footer.organik-footer {
        background: var(--dark-green);
        color: rgba(255,255,255,.75);
        padding-top: 3.5rem;
    }
    footer.organik-footer h6 { color: #fff; font-weight: 700; margin-bottom: 14px; font-family: 'Nunito', sans-serif; }
    footer.organik-footer a { color: rgba(255,255,255,.65); text-decoration: none; font-size: .84rem; display: block; margin-bottom: 6px; }
    footer.organik-footer a:hover { color: #a5d6a7; }
    .footer-bottom { background: rgba(0,0,0,.25); padding: 14px 0; text-align: center; font-size: .8rem; color: rgba(255,255,255,.45); }

    /* ======= PRODUCT CARDS ======= */
    .product-item {
        border: 1px solid #ececec;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        transition: all .3s;
        height: 100%;
    }
    .product-item:hover {
        box-shadow: 0 8px 28px rgba(0,0,0,.1);
        transform: translateY(-4px);
    }
    .product-item figure {
        margin: 0; padding: 20px;
        background: #f9fafb; text-align: center;
    }
    .product-item figure img {
        height: 170px; object-fit: contain;
        transition: transform .3s;
    }
    .product-item:hover figure img { transform: scale(1.06); }
    .product-item .info { padding: 12px 14px 14px; }
    .product-item h3 { font-size: .88rem; font-weight: 600; color: #333; margin: 0 0 4px; }
    .product-item .price { font-size: 1rem; font-weight: 700; color: var(--primary-green); }
    .product-item .price-old { font-size: .8rem; color: #aaa; text-decoration: line-through; }
    .btn-add-cart {
        background: var(--primary-green); color: #fff;
        border: none; border-radius: 6px;
        font-size: .82rem; padding: 7px 12px;
        transition: all .3s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-add-cart:hover { background: #388e3c; color: #fff; }
    .btn-wishlist-sm {
        border: 1px solid #e0e0e0; border-radius: 6px;
        padding: 7px 10px; color: #888; background: #fff;
        font-size: .82rem; transition: all .3s;
    }
    .btn-wishlist-sm:hover { border-color: #ef5350; color: #ef5350; }

    /* ======= SKELETON ======= */
    .skeleton {
        animation: shimmer 1.4s infinite;
        background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        border-radius: 6px;
    }
    @keyframes shimmer { 0%{background-position:-200% 0} 100%{background-position:200% 0} }

    /* ======= ALERTS ======= */
    .alert { border-radius: 8px; }

    /* ======= CATEGORY CAROUSEL ======= */
    .cat-carousel-img {
        width: 90px; height: 90px; border-radius: 50%;
        object-fit: cover; border: 3px solid #e8f5e9;
        transition: border-color .3s;
    }
    .category-carousel .swiper-slide:hover .cat-carousel-img { border-color: var(--primary-green); }
    .cat-label { font-size: .78rem; font-weight: 600; color: #444; margin-top: 8px; display: block; text-align: center; }
</style>

@stack('styles')
