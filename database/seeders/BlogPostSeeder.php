<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '5 Kesalahan Umum dalam Merawat Monstera',
                'slug' => '5-kesalahan-umum-merawat-monstera',
                'excerpt' => 'Pelajari kesalahan-kesalahan yang sering dilakukan pemula dalam merawat Monstera dan cara mengatasinya.',
                'content' => 'Monstera adalah tanaman yang sangat populer. Namun, banyak pemula yang melakukan kesalahan dalam perawatannya...',
                'category' => 'Perawatan',
                'category_slug' => 'perawatan',
                'author' => 'Dewi Lestari',
                'author_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop',
                'image' => 'https://images.unsplash.com/photo-1463320898484-cdee8141c787?w=400&h=300&fit=crop',
                'views' => 2500,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => '7 Tanaman Indoor Terbaik untuk Pemula',
                'slug' => '7-tanaman-indoor-terbaik-untuk-pemula',
                'excerpt' => 'Rekomendasi tanaman indoor yang mudah dirawat dan cocok untuk Anda yang baru memulai hobi berkebun.',
                'content' => 'Bagi pemula, memilih tanaman indoor yang tepat sangat penting. Berikut rekomendasi tanaman yang tahan banting...',
                'category' => 'Tanaman Indoor',
                'category_slug' => 'tanaman-indoor',
                'author' => 'Budi Santoso',
                'author_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop',
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=300&fit=crop',
                'views' => 3200,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Cara Membuat Taman Sukulen Mini',
                'slug' => 'cara-membuat-taman-sukulen-mini',
                'excerpt' => 'Panduan lengkap membuat taman sukulen mini yang cantik untuk menghiasi meja kerja atau sudut rumah Anda.',
                'content' => 'Sukulen adalah pilihan tepat untuk taman mini. Mereka tidak membutuhkan banyak air dan perawatan...',
                'category' => 'Sukulen',
                'category_slug' => 'sukulen',
                'author' => 'Sari Wijaya',
                'author_avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop',
                'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=300&fit=crop',
                'views' => 1800,
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
