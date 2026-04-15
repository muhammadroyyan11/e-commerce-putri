<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('site_name', 'GreenHaven');
        Setting::set('site_logo', '');
        Setting::set('payment_methods', "Transfer Bank BCA\nTransfer Bank Mandiri\nCOD (Bayar di Tempat)");
    }
}
