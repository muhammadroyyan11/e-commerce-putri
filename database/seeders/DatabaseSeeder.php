<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategoryProductSeeder::class,
            SettingSeeder::class,
            PaymentMethodSeeder::class,
            BlogPostSeeder::class,
            ShippingZoneSeeder::class,
        ]);
    }
}
