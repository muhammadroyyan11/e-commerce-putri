<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')->where('is_active', true)->take(8)->get()->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'category' => $p->category?->name ?? 'Tanaman',
            'price' => $p->price,
            'original_price' => $p->original_price,
            'discount' => $p->discount,
            'image' => $p->image ?? 'https://via.placeholder.com/400x500',
            'height' => $p->height,
            'light' => $p->light,
            'care_level' => $p->care_level,
            'watering' => $p->watering,
            'badge' => $p->badge,
        ]);

        $categories = Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->take(4)->get()->map(fn($c) => [
            'name' => $c->name,
            'slug' => $c->slug,
            'count' => $c->products_count,
            'image' => $c->image ?? 'https://via.placeholder.com/400x400',
            'icon' => $c->icon ?? 'fa-leaf',
        ]);

        $testimonials = $this->getTestimonials();
        $benefits = $this->getBenefits();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];

        return view('pages.home', compact('featuredProducts', 'categories', 'testimonials', 'benefits', 'wishlistIds'));
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ]);

        Newsletter::create($validated);

        return redirect()->back()->with('success', 'Terima kasih telah berlangganan newsletter kami!');
    }

    private function getTestimonials()
    {
        return [
            ['name' => 'Sarah Amelia', 'location' => 'Jakarta', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop', 'comment' => '"Pelayanan sangat bagus! Tanaman sampai dalam kondisi sempurna."', 'rating' => 5],
            ['name' => 'Budi Santoso', 'location' => 'Bandung', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop', 'comment' => '"LongLeaf adalah toko tanaman online terbaik yang pernah saya coba."', 'rating' => 5],
            ['name' => 'Dewi Lestari', 'location' => 'Surabaya', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop', 'comment' => '"Koleksi tanaman langkanya lengkap! Harga juga bersaing."', 'rating' => 5],
        ];
    }

    private function getBenefits()
    {
        return [
            ['icon' => 'fa-leaf', 'title' => 'Tanaman Sehat', 'description' => 'Setiap tanaman dipilih dengan cermat dan dalam kondisi prima siap tumbuh di rumah Anda.'],
            ['icon' => 'fa-truck', 'title' => 'Pengiriman Aman', 'description' => 'Kemasan khusus yang menjamin tanaman sampai tujuan dalam kondisi segar dan tidak rusak.'],
            ['icon' => 'fa-headset', 'title' => 'Konsultasi Gratis', 'description' => 'Tim ahli kami siap membantu memberikan saran perawatan tanaman kapan saja Anda butuhkan.'],
            ['icon' => 'fa-undo', 'title' => 'Jaminan Kesehatan', 'description' => 'Garansi uang kembali jika tanaman sampai dalam kondisi tidak sehat atau rusak.'],
        ];
    }
}
