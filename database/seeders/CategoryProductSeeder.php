<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tanaman Indoor', 'slug' => 'indoor', 'count' => 120, 'icon' => 'fa-home', 'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=400&fit=crop'],
            ['name' => 'Tanaman Outdoor', 'slug' => 'outdoor', 'count' => 85, 'icon' => 'fa-sun', 'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop'],
            ['name' => 'Sukulen & Kaktus', 'slug' => 'succulent', 'count' => 60, 'icon' => 'fa-spa', 'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=400&fit=crop'],
            ['name' => 'Tanaman Langka', 'slug' => 'rare', 'count' => 25, 'icon' => 'fa-gem', 'image' => 'https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=400&h=400&fit=crop'],
            ['name' => 'Kaktus', 'slug' => 'cactus', 'count' => 15, 'icon' => 'fa-seedling', 'image' => ''],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            ['name' => 'Monstera Deliciosa', 'slug' => 'monstera-deliciosa', 'category_slug' => 'indoor', 'price' => 350000, 'original_price' => 450000, 'discount' => 20, 'image' => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=400&h=500&fit=crop', 'height' => '60-80cm', 'light' => 'Teduh', 'care_level' => 'Mudah', 'watering' => 'Sedang', 'badge' => 'sale', 'stock' => 15],
            ['name' => 'Lidah Mertua', 'slug' => 'lidah-mertua', 'category_slug' => 'succulent', 'price' => 85000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1599598425947-d35101f97d6c?w=400&h=500&fit=crop', 'height' => '30-40cm', 'light' => 'Cerah', 'care_level' => 'Sangat Mudah', 'watering' => 'Jarang', 'badge' => 'new', 'stock' => 30],
            ['name' => 'Pakis Kelabu', 'slug' => 'pakis-kelabu', 'category_slug' => 'indoor', 'price' => 275000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1598542283622-5410a48cf45e?w=400&h=500&fit=crop', 'height' => '40-50cm', 'light' => 'Teduh', 'care_level' => 'Sedang', 'watering' => 'Sering', 'badge' => 'rare', 'stock' => 10],
            ['name' => 'Kaktus Mini Mix', 'slug' => 'kaktus-mini-mix', 'category_slug' => 'cactus', 'price' => 45000, 'original_price' => 60000, 'discount' => 25, 'image' => 'https://images.unsplash.com/photo-1509423355108-b389831e6077?w=400&h=500&fit=crop', 'height' => '5-15cm', 'light' => 'Cerah', 'care_level' => 'Sangat Mudah', 'watering' => 'Jarang', 'badge' => 'indoor', 'stock' => 50],
            ['name' => 'Philodendron Birkin', 'slug' => 'philodendron-birkin', 'category_slug' => 'indoor', 'price' => 425000, 'original_price' => 500000, 'discount' => 15, 'image' => 'https://images.unsplash.com/photo-1598880940371-c756e015fea1?w=400&h=500&fit=crop', 'height' => '40-50cm', 'light' => 'Teduh', 'care_level' => 'Mudah', 'watering' => 'Sedang', 'badge' => 'sale', 'stock' => 8],
            ['name' => 'Calathea Orbifolia', 'slug' => 'calathea-orbifolia', 'category_slug' => 'indoor', 'price' => 195000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?w=400&h=500&fit=crop', 'height' => '30-40cm', 'light' => 'Teduh', 'care_level' => 'Sedang', 'watering' => 'Sering', 'badge' => null, 'stock' => 12],
            ['name' => 'Lavender', 'slug' => 'lavender', 'category_slug' => 'outdoor', 'price' => 150000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1550951298-5c7b95a66b6c?w=400&h=500&fit=crop', 'height' => '30-50cm', 'light' => 'Cerah', 'care_level' => 'Mudah', 'watering' => 'Jarang', 'badge' => 'outdoor', 'stock' => 20],
            ['name' => 'Philodendron Pink Princess', 'slug' => 'philodendron-pink-princess', 'category_slug' => 'rare', 'price' => 850000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1616690248297-50d4c8ef0996?w=400&h=500&fit=crop', 'height' => '30-40cm', 'light' => 'Teduh', 'care_level' => 'Sedang', 'watering' => 'Sedang', 'badge' => 'rare', 'stock' => 5],
            ['name' => 'Echeveria Lola', 'slug' => 'echeveria-lola', 'category_slug' => 'succulent', 'price' => 65000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=500&fit=crop', 'height' => '10-15cm', 'light' => 'Cerah', 'care_level' => 'Sangat Mudah', 'watering' => 'Jarang', 'badge' => null, 'stock' => 40],
            ['name' => 'Rubber Plant', 'slug' => 'rubber-plant', 'category_slug' => 'indoor', 'price' => 295000, 'original_price' => 330000, 'discount' => 10, 'image' => 'https://images.unsplash.com/photo-1600417148543-515eed049e9d?w=400&h=500&fit=crop', 'height' => '60-80cm', 'light' => 'Teduh', 'care_level' => 'Mudah', 'watering' => 'Sedang', 'badge' => 'sale', 'stock' => 18],
            ['name' => 'Bonsai Mini', 'slug' => 'bonsai-mini', 'category_slug' => 'outdoor', 'price' => 125000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1566928405-544c44225944?w=400&h=500&fit=crop', 'height' => '20-30cm', 'light' => 'Cerah', 'care_level' => 'Sedang', 'watering' => 'Rutin', 'badge' => 'outdoor', 'stock' => 7],
            ['name' => 'ZZ Plant', 'slug' => 'zz-plant', 'category_slug' => 'indoor', 'price' => 175000, 'original_price' => null, 'discount' => null, 'image' => 'https://images.unsplash.com/photo-1599598425798-6c8ee1b216b7?w=400&h=500&fit=crop', 'height' => '40-60cm', 'light' => 'Teduh', 'care_level' => 'Sangat Mudah', 'watering' => 'Jarang', 'badge' => 'indoor', 'stock' => 25],
        ];

        foreach ($products as $prod) {
            $category = Category::where('slug', $prod['category_slug'])->first();
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $prod['name'],
                    'slug' => $prod['slug'],
                    'description' => null,
                    'price' => $prod['price'],
                    'original_price' => $prod['original_price'],
                    'discount' => $prod['discount'],
                    'image' => $prod['image'],
                    'height' => $prod['height'],
                    'light' => $prod['light'],
                    'care_level' => $prod['care_level'],
                    'watering' => $prod['watering'],
                    'badge' => $prod['badge'],
                    'stock' => $prod['stock'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
