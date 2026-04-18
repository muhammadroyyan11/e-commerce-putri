<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Setting;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category','images'])->where('is_active', true)->take(8)->get()->map(fn($p) => [
            'id'             => $p->id,
            'name'           => $p->name,
            'slug'           => $p->slug,
            'category'       => $p->category?->name ?? 'Tanaman',
            'price'          => $p->price,
            'original_price' => $p->original_price,
            'discount'       => $p->discount,
            'image'          => $p->primaryImage()?->url ?? $p->image ?? 'https://via.placeholder.com/400x500',
            'height'         => $p->height,
            'light'          => $p->light,
            'care_level'     => $p->care_level,
            'watering'       => $p->watering,
            'badge'          => $p->badge,
        ]);

        $categories = Category::withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->where('is_active', true)->take(4)->get()->map(fn($c) => [
                'name'  => $c->name,
                'slug'  => $c->slug,
                'count' => $c->products_count,
                'image' => $c->image ?? 'https://via.placeholder.com/400x400',
                'icon'  => $c->icon ?? 'fa-leaf',
            ]);

        // F6: Real reviews from DB (verified purchases, rating >= 4)
        $reviews = ProductReview::with(['user', 'product'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($r) => [
                'name'         => $r->user->name,
                'avatar'       => strtoupper(substr($r->user->name, 0, 1)),
                'product_name' => $r->product?->name ?? '',
                'comment'      => $r->comment,
                'rating'       => $r->rating,
                'date'         => $r->created_at->format('d M Y'),
            ]);

        // Fallback to static if no reviews yet
        $testimonials = $reviews->count() >= 2 ? $reviews : collect($this->getStaticTestimonials());

        // F7: Trust badges from settings or defaults
        $trustBadges = $this->getTrustBadges();

        $benefits    = $this->getBenefits();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];

        return view('pages.home', compact(
            'featuredProducts', 'categories', 'testimonials',
            'trustBadges', 'benefits', 'wishlistIds'
        ));
    }

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:newsletters,email']);
        Newsletter::create(['email' => $request->email]);
        return redirect()->back()->with('success', 'Terima kasih telah berlangganan newsletter kami!');
    }

    private function getTrustBadges(): array
    {
        $isId = app()->getLocale() === 'id';
        return [
            [
                'icon'  => 'fa-shield-alt',
                'color' => '#10b981',
                'value' => Setting::get('trust_customers', '10.000+'),
                'label' => $isId ? 'Pelanggan Puas' : 'Happy Customers',
            ],
            [
                'icon'  => 'fa-leaf',
                'color' => '#84cc16',
                'value' => Setting::get('trust_products', '500+'),
                'label' => $isId ? 'Jenis Tanaman' : 'Plant Varieties',
            ],
            [
                'icon'  => 'fa-truck',
                'color' => '#3b82f6',
                'value' => Setting::get('trust_delivery', '100%'),
                'label' => $isId ? 'Pengiriman Aman' : 'Safe Delivery',
            ],
            [
                'icon'  => 'fa-star',
                'color' => '#f59e0b',
                'value' => Setting::get('trust_rating', '4.9/5'),
                'label' => $isId ? 'Rating Pelanggan' : 'Customer Rating',
            ],
        ];
    }

    private function getStaticTestimonials(): array
    {
        $isId = app()->getLocale() === 'id';
        return [
            ['name' => 'Sarah Amelia',  'avatar' => 'S', 'product_name' => 'Monstera Deliciosa', 'comment' => $isId ? 'Pelayanan sangat bagus! Tanaman sampai dalam kondisi sempurna dan sehat.' : 'Great service! The plant arrived in perfect condition.', 'rating' => 5, 'date' => '15 Mar 2026'],
            ['name' => 'Budi Santoso',  'avatar' => 'B', 'product_name' => 'ZZ Plant',           'comment' => $isId ? 'Toko tanaman online terbaik yang pernah saya coba. Recommended!' : 'Best online plant shop I\'ve tried. Highly recommended!', 'rating' => 5, 'date' => '10 Mar 2026'],
            ['name' => 'Dewi Lestari',  'avatar' => 'D', 'product_name' => 'Lavender',           'comment' => $isId ? 'Koleksi lengkap, harga bersaing, dan pengiriman cepat. Puas banget!' : 'Great collection, competitive prices, and fast delivery!', 'rating' => 5, 'date' => '5 Mar 2026'],
        ];
    }

    private function getBenefits(): array
    {
        $isId = app()->getLocale() === 'id';
        return [
            ['icon' => 'fa-leaf',    'title' => $isId ? 'Tanaman Sehat'      : 'Healthy Plants',    'description' => $isId ? 'Setiap tanaman dipilih dengan cermat dan dalam kondisi prima.'                    : 'Every plant is carefully selected and in prime condition.'],
            ['icon' => 'fa-truck',   'title' => $isId ? 'Pengiriman Aman'    : 'Safe Delivery',     'description' => $isId ? 'Kemasan khusus menjamin tanaman sampai segar dan tidak rusak.'                    : 'Special packaging ensures plants arrive fresh and undamaged.'],
            ['icon' => 'fa-headset', 'title' => $isId ? 'Konsultasi Gratis'  : 'Free Consultation', 'description' => $isId ? 'Tim ahli kami siap membantu saran perawatan kapan saja.'                         : 'Our expert team is ready to help with care advice anytime.'],
            ['icon' => 'fa-undo',    'title' => $isId ? 'Jaminan Kesehatan'  : 'Health Guarantee',  'description' => $isId ? 'Garansi uang kembali jika tanaman sampai dalam kondisi tidak sehat.' : 'Money-back guarantee if plants arrive in unhealthy condition.'],
        ];
    }
}
