<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ShippingZone::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $zones = [
            [
                'name'       => 'Indonesia',
                'flat_rate'  => 25000,
                'sort_order' => 1,
                'countries'  => ['Indonesia'],
            ],
            [
                'name'       => 'Asia Tenggara (SEA)',
                'flat_rate'  => 150000,
                'sort_order' => 2,
                'countries'  => [
                    'Malaysia', 'Singapore', 'Thailand', 'Philippines', 'Vietnam',
                    'Myanmar', 'Cambodia', 'Laos', 'Brunei', 'Timor-Leste',
                ],
            ],
            [
                'name'       => 'Asia Timur',
                'flat_rate'  => 250000,
                'sort_order' => 3,
                'countries'  => [
                    'Japan', 'South Korea', 'China', 'Taiwan', 'Hong Kong', 'Macau', 'Mongolia',
                ],
            ],
            [
                'name'       => 'Asia Selatan & Tengah',
                'flat_rate'  => 280000,
                'sort_order' => 4,
                'countries'  => [
                    'India', 'Pakistan', 'Bangladesh', 'Sri Lanka', 'Nepal', 'Bhutan',
                    'Maldives', 'Afghanistan', 'Kazakhstan', 'Uzbekistan', 'Turkmenistan',
                    'Tajikistan', 'Kyrgyzstan',
                ],
            ],
            [
                'name'       => 'Timur Tengah',
                'flat_rate'  => 300000,
                'sort_order' => 5,
                'countries'  => [
                    'Saudi Arabia', 'United Arab Emirates', 'Qatar', 'Kuwait', 'Bahrain',
                    'Oman', 'Jordan', 'Lebanon', 'Israel', 'Iraq', 'Iran', 'Syria', 'Yemen',
                ],
            ],
            [
                'name'       => 'Australia & Pasifik',
                'flat_rate'  => 320000,
                'sort_order' => 6,
                'countries'  => [
                    'Australia', 'New Zealand', 'Papua New Guinea', 'Fiji', 'Solomon Islands',
                    'Vanuatu', 'Samoa', 'Tonga', 'Kiribati', 'Micronesia', 'Palau', 'Nauru',
                    'Tuvalu', 'Marshall Islands',
                ],
            ],
            [
                'name'       => 'Eropa Barat',
                'flat_rate'  => 400000,
                'sort_order' => 7,
                'countries'  => [
                    'United Kingdom', 'Germany', 'France', 'Netherlands', 'Belgium',
                    'Switzerland', 'Austria', 'Sweden', 'Norway', 'Denmark', 'Finland',
                    'Ireland', 'Portugal', 'Spain', 'Italy', 'Luxembourg', 'Iceland',
                    'Liechtenstein', 'Monaco', 'San Marino', 'Vatican City',
                ],
            ],
            [
                'name'       => 'Eropa Timur & Tengah',
                'flat_rate'  => 420000,
                'sort_order' => 8,
                'countries'  => [
                    'Poland', 'Czech Republic', 'Slovakia', 'Hungary', 'Romania', 'Bulgaria',
                    'Croatia', 'Slovenia', 'Serbia', 'Bosnia and Herzegovina', 'Montenegro',
                    'North Macedonia', 'Albania', 'Kosovo', 'Greece', 'Cyprus',
                    'Estonia', 'Latvia', 'Lithuania', 'Ukraine', 'Moldova', 'Belarus',
                    'Russia',
                ],
            ],
            [
                'name'       => 'Amerika Utara',
                'flat_rate'  => 450000,
                'sort_order' => 9,
                'countries'  => [
                    'United States', 'Canada', 'Mexico',
                ],
            ],
            [
                'name'       => 'Amerika Tengah & Karibia',
                'flat_rate'  => 480000,
                'sort_order' => 10,
                'countries'  => [
                    'Guatemala', 'Belize', 'Honduras', 'El Salvador', 'Nicaragua',
                    'Costa Rica', 'Panama', 'Cuba', 'Jamaica', 'Haiti', 'Dominican Republic',
                    'Puerto Rico', 'Trinidad and Tobago', 'Barbados', 'Bahamas',
                ],
            ],
            [
                'name'       => 'Amerika Selatan',
                'flat_rate'  => 500000,
                'sort_order' => 11,
                'countries'  => [
                    'Brazil', 'Argentina', 'Chile', 'Colombia', 'Peru', 'Venezuela',
                    'Ecuador', 'Bolivia', 'Paraguay', 'Uruguay', 'Guyana', 'Suriname',
                ],
            ],
            [
                'name'       => 'Afrika',
                'flat_rate'  => 550000,
                'sort_order' => 12,
                'countries'  => [
                    'South Africa', 'Nigeria', 'Kenya', 'Egypt', 'Ethiopia', 'Ghana',
                    'Tanzania', 'Uganda', 'Morocco', 'Algeria', 'Tunisia', 'Libya',
                    'Senegal', 'Ivory Coast', 'Cameroon', 'Zimbabwe', 'Zambia',
                    'Mozambique', 'Madagascar', 'Angola', 'Sudan', 'Somalia',
                ],
            ],
        ];

        foreach ($zones as $zone) {
            ShippingZone::create($zone);
        }
    }
}
