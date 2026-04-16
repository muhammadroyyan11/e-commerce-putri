<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        PaymentMethod::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        PaymentMethod::insert([
            [
                'name'           => 'PayPal',
                'type'           => 'manual',
                'account_name'   => 'GreenHaven',
                'account_number' => '1234567890',
                'logo'           => null,
                'is_active'      => true,
                'sort_order'     => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Bayar Online (VA / E-Wallet / QRIS)',
                'type'           => 'midtrans',
                'account_name'   => '-',
                'account_number' => '-',
                'logo'           => null,
                'is_active'      => true,
                'sort_order'     => 2,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
