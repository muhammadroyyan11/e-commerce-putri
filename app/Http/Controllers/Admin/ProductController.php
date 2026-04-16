<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|integer|min:0|max:100',
            'height'         => 'nullable|string|max:255',
            'light'          => 'nullable|string|max:255',
            'care_level'     => 'nullable|string|max:255',
            'watering'       => 'nullable|string|max:255',
            'badge'          => 'nullable|string|max:255',
            'stock'          => 'nullable|integer|min:0',
            'weight'         => 'required|integer|min:1',
            'is_active'      => 'boolean',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        // Keep legacy image field as primary image URL for backward compat
        $validated['image']     = null;

        $product = Product::create($validated);

        $this->handleImageUploads($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|integer|min:0|max:100',
            'height'         => 'nullable|string|max:255',
            'light'          => 'nullable|string|max:255',
            'care_level'     => 'nullable|string|max:255',
            'watering'       => 'nullable|string|max:255',
            'badge'          => 'nullable|string|max:255',
            'stock'          => 'nullable|integer|min:0',
            'weight'         => 'required|integer|min:1',
            'is_active'      => 'boolean',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'delete_images'  => 'nullable|array',
            'delete_images.*'=> 'integer|exists:product_images,id',
            'primary_image'  => 'nullable|integer|exists:product_images,id',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', false);

        $product->update($validated);

        // Delete selected images
        if ($request->filled('delete_images')) {
            $toDelete = ProductImage::whereIn('id', $request->delete_images)
                ->where('product_id', $product->id)->get();
            foreach ($toDelete as $img) {
                if (! str_starts_with($img->path, 'http')) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }
        }

        // Set primary image
        if ($request->filled('primary_image')) {
            $product->images()->update(['is_primary' => false]);
            ProductImage::where('id', $request->primary_image)
                ->where('product_id', $product->id)
                ->update(['is_primary' => true]);
        }

        $this->handleImageUploads($request, $product);

        // Sync legacy image field with primary
        $primary = $product->fresh('images')->primaryImage();
        if ($primary) {
            $product->update(['image' => $primary->url]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            if (! str_starts_with($img->path, 'http')) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function handleImageUploads(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) return;

        $existingCount = $product->images()->count();

        foreach ($request->file('images') as $i => $file) {
            $path = $file->store('products', 'public');
            $isPrimary = ($existingCount === 0 && $i === 0);

            ProductImage::create([
                'product_id' => $product->id,
                'path'       => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $existingCount + $i,
            ]);

            $existingCount++;
        }

        // Sync legacy image field
        $primary = $product->fresh('images')->primaryImage();
        if ($primary) {
            $product->update(['image' => $primary->url]);
        }
    }
}
