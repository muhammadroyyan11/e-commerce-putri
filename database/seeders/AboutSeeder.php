<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'about_hero_image'       => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop',
            'about_story_title_id'   => 'Dari Kecintaan pada Tanaman, Lahirlah LongLeaf',
            'about_story_title_en'   => 'Born from a Love of Plants, LongLeaf Was Created',
            'about_story_desc1_id'   => 'LongLeaf lahir dari kecintaan mendalam terhadap tanaman dan alam. Kami percaya bahwa setiap rumah berhak memiliki sentuhan hijau yang menyegarkan.',
            'about_story_desc1_en'   => 'LongLeaf was born from a deep love of plants and nature. We believe every home deserves a refreshing touch of green.',
            'about_story_desc2_id'   => 'Dengan tim yang berpengalaman di bidang hortikultura, kami memastikan setiap tanaman yang sampai ke tangan Anda dalam kondisi terbaik.',
            'about_story_desc2_en'   => 'With a team experienced in horticulture, we ensure every plant that reaches your hands is in the best condition.',
            'about_stat_years'       => '4+',
            'about_stat_plants'      => '50K+',
            'about_stat_customers'   => '10K+',
            'about_mission_id'       => 'Menghadirkan tanaman berkualitas tinggi dengan edukasi perawatan yang mudah dipahami, sehingga siapa pun bisa menikmati keindahan alam di rumah mereka.',
            'about_mission_en'       => 'To deliver high-quality plants with easy-to-understand care education, so anyone can enjoy the beauty of nature in their home.',
            'about_vision_id'        => 'Menjadi toko tanaman online terpercaya di Asia Tenggara yang menginspirasi gaya hidup hijau dan berkelanjutan.',
            'about_vision_en'        => 'To become the most trusted online plant store in Southeast Asia, inspiring a green and sustainable lifestyle.',
            'about_value1_icon'      => '🌱',
            'about_value1_title_id'  => 'Kualitas',
            'about_value1_title_en'  => 'Quality',
            'about_value1_text_id'   => 'Setiap tanaman dipilih dengan teliti untuk memastikan kualitas terbaik.',
            'about_value1_text_en'   => 'Every plant is carefully selected to ensure the best quality.',
            'about_value2_icon'      => '💚',
            'about_value2_title_id'  => 'Keberlanjutan',
            'about_value2_title_en'  => 'Sustainability',
            'about_value2_text_id'   => 'Kami berkomitmen pada praktik ramah lingkungan di setiap aspek bisnis.',
            'about_value2_text_en'   => 'We are committed to eco-friendly practices in every aspect of our business.',
            'about_value3_icon'      => '📚',
            'about_value3_title_id'  => 'Edukasi',
            'about_value3_title_en'  => 'Education',
            'about_value3_text_id'   => 'Kami berbagi pengetahuan perawatan tanaman agar Anda sukses merawatnya.',
            'about_value3_text_en'   => 'We share plant care knowledge so you can successfully nurture them.',
            'about_value4_icon'      => '🤝',
            'about_value4_title_id'  => 'Komunitas',
            'about_value4_title_en'  => 'Community',
            'about_value4_text_id'   => 'Membangun komunitas pecinta tanaman yang saling mendukung dan menginspirasi.',
            'about_value4_text_en'   => 'Building a community of plant lovers who support and inspire each other.',
            'about_cta_title_id'     => 'Siap Memulai Perjalanan Hijau Anda?',
            'about_cta_title_en'     => 'Ready to Start Your Green Journey?',
            'about_cta_desc_id'      => 'Jelajahi koleksi tanaman kami dan temukan tanaman sempurna untuk rumah Anda.',
            'about_cta_desc_en'      => 'Explore our plant collection and find the perfect plant for your home.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // Default team members
        if (TeamMember::count() === 0) {
            $members = [
                ['name' => 'Andi Wijaya',  'position_id' => 'Pendiri & CEO',          'position_en' => 'Founder & CEO',          'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face', 'order' => 1],
                ['name' => 'Sari Melati',  'position_id' => 'Kepala Hortikultura',     'position_en' => 'Head of Horticulture',   'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop&crop=face', 'order' => 2],
                ['name' => 'Budi Santoso', 'position_id' => 'Manajer Operasional',     'position_en' => 'Operations Manager',    'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face', 'order' => 3],
                ['name' => 'Rina Dewi',    'position_id' => 'Customer Success',        'position_en' => 'Customer Success',      'photo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop&crop=face', 'order' => 4],
            ];

            foreach ($members as $m) {
                TeamMember::create(array_merge($m, ['is_active' => true]));
            }
        }
    }
}
