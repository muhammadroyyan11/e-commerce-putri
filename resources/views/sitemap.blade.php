<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- Static pages --}}
    @php $staticPages = [
        ['url' => route('home'),       'priority' => '1.0',  'freq' => 'daily'],
        ['url' => route('shop'),       'priority' => '0.9',  'freq' => 'daily'],
        ['url' => route('blog'),       'priority' => '0.8',  'freq' => 'weekly'],
        ['url' => route('about'),      'priority' => '0.6',  'freq' => 'monthly'],
        ['url' => route('contact'),    'priority' => '0.6',  'freq' => 'monthly'],
        ['url' => route('care.guide'), 'priority' => '0.7',  'freq' => 'monthly'],
        ['url' => route('faq'),        'priority' => '0.6',  'freq' => 'monthly'],
        ['url' => route('category.indoor'),    'priority' => '0.8', 'freq' => 'weekly'],
        ['url' => route('category.outdoor'),   'priority' => '0.8', 'freq' => 'weekly'],
        ['url' => route('category.succulent'), 'priority' => '0.8', 'freq' => 'weekly'],
        ['url' => route('category.rare'),      'priority' => '0.8', 'freq' => 'weekly'],
    ]; @endphp

    @foreach($staticPages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <changefreq>{{ $page['freq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    {{-- Products --}}
    @foreach($products as $product)
    <url>
        <loc>{{ route('product.detail', $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Blog posts --}}
    @foreach($blogPosts as $post)
    <url>
        <loc>{{ route('blog.detail', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

</urlset>
