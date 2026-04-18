<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Wishlist;
use App\Helpers\SeoMeta;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])->where('is_active', true);

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) $query->where('category_id', $category->id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'featured');
        match ($sort) {
            'price-low'  => $query->orderBy('price', 'asc'),
            'price-high' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $perPage     = 9;
        $paginated   = $query->paginate($perPage)->withQueryString();
        $products    = $paginated->getCollection()->map(fn($p) => $this->mapProduct($p));
        $wishlistIds = auth()->check() ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray() : [];

        // AJAX infinite scroll — return JSON with rendered HTML
        if ($request->ajax() || $request->wantsJson()) {
            $html = '';
            foreach ($products as $product) {
                $html .= view('partials.product-card', compact('product', 'wishlistIds'))->render();
            }
            return response()->json([
                'html'     => $html,
                'has_more' => $paginated->hasMorePages(),
                'next_page'=> $paginated->currentPage() + 1,
                'total'    => $paginated->total(),
            ]);
        }

        $categories = $this->getCategories();
        $search     = $request->get('search', '');

        return view('pages.shop', [
            'products'    => $products,
            'paginated'   => $paginated,
            'categories'  => $categories,
            'sort'        => $sort,
            'wishlistIds' => $wishlistIds,
            'search'      => $search,
            'seo'         => SeoMeta::shop(
                $request->filled('search') ? 'Hasil pencarian: ' . $request->search : '',
                'Jelajahi ratusan jenis tanaman hias indoor dan outdoor. Harga terjangkau, pengiriman aman ke seluruh Indonesia.'
            ),
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'images'])->where('slug', $slug)->where('is_active', true)->first();

        if (!$product) {
            abort(404);
        }

        $mappedProduct = $this->mapProduct($product);
        $relatedProducts = Product::with('images')->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get()
            ->map(fn($p) => $this->mapProduct($p));

        $reviews = $this->getProductReviews($product->id);
        $inWishlist = auth()->check() ? Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() : false;

        return view('pages.product-detail', [
            'product'         => $mappedProduct,
            'productImages'   => $product->images,
            'relatedProducts' => $relatedProducts,
            'reviews'         => $reviews,
            'avgRating'       => $reviews->avg('rating') ?? 0,
            'reviewCount'     => $reviews->count(),
            'inWishlist'      => $inWishlist,
            'seo'             => SeoMeta::product($mappedProduct, $reviews->avg('rating') ?? 0, $reviews->count()),
        ])->with([
            'aiProductId'   => $product->id,
            'aiProductName' => $product->name,
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
        $primaryImage = $product->relationLoaded('images')
            ? $product->primaryImage()
            : null;

        $imageUrl = $primaryImage?->url
            ?? $product->image
            ?? 'https://via.placeholder.com/400x500';

        return [
            'id'             => $product->id,
            'name'           => $product->name,
            'slug'           => $product->slug,
            'category'       => $product->category?->name ?? 'Tanaman',
            'category_slug'  => $product->category?->slug ?? '',
            'price'          => $product->price,
            'original_price' => $product->original_price,
            'discount'       => $product->discount,
            'image'          => $imageUrl,
            'description'    => $product->description,
            'height'         => $product->height,
            'light'          => $product->light,
            'care_level'     => $product->care_level,
            'watering'       => $product->watering,
            'badge'          => $product->badge,
            'stock'          => $product->stock,
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
        return ProductReview::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->get()
            ->map(fn($r) => [
                'name'    => $r->user->name,
                'avatar'  => null,
                'rating'  => $r->rating,
                'date'    => $r->created_at->format('d M Y'),
                'comment' => $r->comment,
                'verified' => true,
            ]);
    }
}
