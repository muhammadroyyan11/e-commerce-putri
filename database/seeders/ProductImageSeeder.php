<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Seed 3+ Unsplash images per product.
     * Images are stored as full URLs (backward-compatible with ProductImage::getUrlAttribute).
     */
    public function run(): void
    {
        // Clear existing product_images rows first (idempotent)
        ProductImage::query()->delete();

        $data = [

            'monstera-deliciosa' => [
                'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1637967886160-fd78dc3ce3f5?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1632207691143-643e2a9a9361?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1620127682229-33388276e540?w=800&h=900&fit=crop',
            ],

            'lidah-mertua' => [
                'https://images.unsplash.com/photo-1599598425947-d35101f97d6c?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=900&fit=crop',
            ],

            'pakis-kelabu' => [
                'https://images.unsplash.com/photo-1598542283622-5410a48cf45e?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1509423355108-b389831e6077?w=800&h=900&fit=crop',
            ],

            'kaktus-mini-mix' => [
                'https://images.unsplash.com/photo-1509423355108-b389831e6077?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?w=800&h=900&fit=crop',
            ],

            'philodendron-birkin' => [
                'https://images.unsplash.com/photo-1598880940371-c756e015fea1?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1616690248297-50d4c8ef0996?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1637967886160-fd78dc3ce3f5?w=800&h=900&fit=crop',
            ],

            'calathea-orbifolia' => [
                'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1620127682229-33388276e540?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1632207691143-643e2a9a9361?w=800&h=900&fit=crop',
            ],

            'lavender' => [
                'https://images.unsplash.com/photo-1550951298-5c7b95a66b6c?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1468327768560-75b778cbb551?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=900&fit=crop',
            ],

            'philodendron-pink-princess' => [
                'https://images.unsplash.com/photo-1616690248297-50d4c8ef0996?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1598880940371-c756e015fea1?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1637967886160-fd78dc3ce3f5?w=800&h=900&fit=crop',
            ],

            'echeveria-lola' => [
                'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1509423355108-b389831e6077?w=800&h=900&fit=crop',
            ],

            'rubber-plant' => [
                'https://images.unsplash.com/photo-1600417148543-515eed049e9d?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=800&h=900&fit=crop',
            ],

            'bonsai-mini' => [
                'https://images.unsplash.com/photo-1566928405-544c44225944?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1599598425798-6c8ee1b216b7?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=900&fit=crop',
            ],

            'zz-plant' => [
                'https://images.unsplash.com/photo-1599598425798-6c8ee1b216b7?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1600417148543-515eed049e9d?w=800&h=900&fit=crop',
                'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=800&h=900&fit=crop',
            ],

        ];

        foreach ($data as $slug => $urls) {
            $product = Product::where('slug', $slug)->first();
            if (! $product) continue;

            foreach ($urls as $i => $url) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $url,   // stored as URL — getUrlAttribute handles this
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }

            // Sync legacy image field with primary
            $product->update(['image' => $urls[0]]);
        }

        $this->command->info('Product images seeded: ' . count($data) . ' products updated.');
    }
}
