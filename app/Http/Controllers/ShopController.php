<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'featured');
        if ($sort === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price-high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get()->map(fn($p) => $this->mapProduct($p));
        $categories = $this->getCategories();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];
        $search = $request->get('search', '');

        return view('pages.shop', compact('products', 'categories', 'sort', 'wishlistIds', 'search'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->first();

        if (!$product) {
            abort(404);
        }

        $mappedProduct = $this->mapProduct($product);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $reviews = $this->getProductReviews($product->id);
        $inWishlist = auth()->check() ? Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() : false;

        return view('pages.product-detail', [
            'product' => $mappedProduct,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'inWishlist' => $inWishlist,
        ]);
    }

    public function indoor()
    {
        $category = Category::where('slug', 'indoor')->first();
        $products = Product::with('category')
            ->where('category_id', $category?->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $categories = $this->getCategories();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];
        $pageTitle = 'Tanaman Indoor';

        return view('pages.shop', compact('products', 'categories', 'pageTitle', 'wishlistIds'));
    }

    public function outdoor()
    {
        $category = Category::where('slug', 'outdoor')->first();
        $products = Product::with('category')
            ->where('category_id', $category?->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $categories = $this->getCategories();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];
        $pageTitle = 'Tanaman Outdoor';

        return view('pages.shop', compact('products', 'categories', 'pageTitle', 'wishlistIds'));
    }

    public function succulent()
    {
        $slugs = ['succulent', 'cactus'];
        $categoryIds = Category::whereIn('slug', $slugs)->pluck('id')->toArray();
        $products = Product::with('category')
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $categories = $this->getCategories();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];
        $pageTitle = 'Sukulen & Kaktus';

        return view('pages.shop', compact('products', 'categories', 'pageTitle', 'wishlistIds'));
    }

    public function rare()
    {
        $category = Category::where('slug', 'rare')->first();
        $products = Product::with('category')
            ->where('category_id', $category?->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $categories = $this->getCategories();
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];
        $pageTitle = 'Tanaman Langka';

        return view('pages.shop', compact('products', 'categories', 'pageTitle', 'wishlistIds'));
    }

    public function toggleWishlist(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.',
                'redirect' => route('login'),
            ], 401);
        }

        $productId = $request->input('product_id');
        $wishlist = Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $productId]);
            $status = 'added';
        }

        $count = Wishlist::where('user_id', auth()->id())->count();

        return response()->json([
            'success' => true,
            'status' => $status,
            'count' => $count,
            'message' => $status === 'added' ? 'Ditambahkan ke wishlist' : 'Dihapus dari wishlist',
        ]);
    }

    private function mapProduct(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => $product->category?->name ?? 'Tanaman',
            'category_slug' => $product->category?->slug ?? '',
            'price' => $product->price,
            'original_price' => $product->original_price,
            'discount' => $product->discount,
            'image' => $product->image ?? 'https://via.placeholder.com/400x500',
            'height' => $product->height,
            'light' => $product->light,
            'care_level' => $product->care_level,
            'watering' => $product->watering,
            'badge' => $product->badge,
            'stock' => $product->stock,
        ];
    }

    private function getCategories()
    {
        return Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get()->map(fn($c) => [
            'name' => $c->name,
            'slug' => $c->slug,
            'count' => $c->products_count,
        ]);
    }

    private function getProductReviews($productId)
    {
        return [
            ['name' => 'Sarah Amelia', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop', 'rating' => 5, 'date' => '15 Jan 2026', 'comment' => 'Tanaman sampai dengan selamat!', 'verified' => true],
            ['name' => 'Michael Chen', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop', 'rating' => 4, 'date' => '12 Jan 2026', 'comment' => 'Kualitas bagus, pengiriman cepat.', 'verified' => true],
        ];
    }
}
