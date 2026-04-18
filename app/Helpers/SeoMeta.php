<?php

namespace App\Helpers;

use App\Models\Setting;

class SeoMeta
{
    public string $title;
    public string $description;
    public string $image;
    public string $url;
    public string $type;
    public ?array $schema;

    public function __construct(
        string  $title       = '',
        string  $description = '',
        string  $image       = '',
        string  $url         = '',
        string  $type        = 'website',
        ?array  $schema      = null,
    ) {
        $siteName = Setting::get('site_name', 'GreenHaven');
        $siteUrl  = config('app.url');
        $logo     = Setting::get('site_logo', '');

        $this->title       = $title       ?: $siteName . ' — Toko Tanaman Online';
        $this->description = $description ?: 'Temukan koleksi tanaman hias terbaik untuk mempercantik rumah Anda. Pengiriman aman ke seluruh Indonesia.';
        $this->image       = $image       ?: ($logo ?: $siteUrl . '/images/og-default.jpg');
        $this->url         = $url         ?: request()->url();
        $this->type        = $type;
        $this->schema      = $schema;
    }

    /** Shortcut for product pages */
    public static function product(array $product, float $avgRating = 0, int $reviewCount = 0): self
    {
        $siteName = Setting::get('site_name', 'GreenHaven');
        $name     = $product['name'];
        $price    = number_format($product['price'], 0, ',', '.');

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => $name,
            'description' => strip_tags($product['description'] ?? "{$name} — tanaman hias berkualitas dari {$siteName}."),
            'image'       => $product['image'],
            'url'         => request()->url(),
            'brand'       => ['@type' => 'Brand', 'name' => $siteName],
            'offers'      => [
                '@type'         => 'Offer',
                'price'         => $product['price'],
                'priceCurrency' => 'IDR',
                'availability'  => ($product['stock'] ?? 0) > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'url'           => request()->url(),
                'seller'        => ['@type' => 'Organization', 'name' => $siteName],
            ],
        ];

        if ($reviewCount > 0) {
            $schema['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => round($avgRating, 1),
                'reviewCount' => $reviewCount,
                'bestRating'  => 5,
                'worstRating' => 1,
            ];
        }

        return new self(
            title:       "{$name} — {$siteName}",
            description: "Beli {$name} online. Harga Rp{$price}. Pengiriman aman ke seluruh Indonesia. " . ($product['care_level'] ? "Tingkat perawatan: {$product['care_level']}." : ''),
            image:       $product['image'],
            type:        'product',
            schema:      $schema,
        );
    }

    /** Shortcut for blog posts */
    public static function blog(object $post): self
    {
        $siteName = Setting::get('site_name', 'GreenHaven');

        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $post->title,
            'description'      => $post->excerpt ?? '',
            'image'            => $post->image ?? '',
            'author'           => ['@type' => 'Person', 'name' => $post->author ?? $siteName],
            'publisher'        => [
                '@type' => 'Organization',
                'name'  => $siteName,
                'logo'  => ['@type' => 'ImageObject', 'url' => Setting::get('site_logo', '')],
            ],
            'datePublished'    => $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String(),
            'dateModified'     => $post->updated_at->toIso8601String(),
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => request()->url()],
        ];

        return new self(
            title:       "{$post->title} — {$siteName}",
            description: $post->excerpt ?? '',
            image:       $post->image ?? '',
            type:        'article',
            schema:      $schema,
        );
    }

    /** Shortcut for shop/category pages */
    public static function shop(string $title = '', string $description = ''): self
    {
        $siteName = Setting::get('site_name', 'GreenHaven');
        return new self(
            title:       ($title ?: 'Koleksi Tanaman') . " — {$siteName}",
            description: $description ?: 'Jelajahi ratusan jenis tanaman hias indoor dan outdoor. Harga terjangkau, pengiriman aman.',
        );
    }
}
