<?php

namespace App\Services;

use App\Models\ApiSetting;
use App\Models\ShippingZone;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShippingService
{
    /**
     * Get available shipping options.
     * Returns array of ['courier','service','description','cost','etd']
     */
    public function getOptions(string $country, string $cityId, int $weightGram): array
    {
        if ($country === 'Indonesia') {
            return $this->getRajaOngkirOptions($cityId, $weightGram);
        }

        return $this->getInternationalOptions($country, $weightGram);
    }

    // ── Domestic (RajaOngkir) ────────────────────────────────────────────────

    public function getCities(): array
    {
        if (!ApiSetting::isEnabled('rajaongkir')) return [];

        return Cache::remember('rajaongkir_cities', 86400, function () {
            $key = ApiSetting::get('rajaongkir_api_key');
            $provinces = Http::withHeaders(['key' => $key])
                ->get('https://rajaongkir.komerce.id/api/v1/destination/province')
                ->json('data', []);

            $cities = [];
            foreach ($provinces as $province) {
                $res = Http::withHeaders(['key' => $key])
                    ->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province['id']}")
                    ->json('data', []);
                foreach ($res as $city) {
                    $cities[] = [
                        'city_id'   => $city['id'],
                        'city_name' => $city['name'],
                        'province'  => $province['name'],
                    ];
                }
            }
            return $cities;
        });
    }

    private function getRajaOngkirOptions(string $destinationCityId, int $weightGram): array
    {
        if (!ApiSetting::isEnabled('rajaongkir') || !$destinationCityId) {
            return [['courier' => 'flat', 'service' => 'Reguler', 'description' => 'Flat Rate', 'cost' => 25000, 'etd' => '3-5 hari']];
        }

        $apiKey   = ApiSetting::get('rajaongkir_api_key');
        $originId = ApiSetting::get('rajaongkir_origin_city', '391');
        $couriers = ['jne', 'tiki', 'pos', 'sicepat', 'jnt'];
        $results  = [];

        foreach ($couriers as $courier) {
            $response = Http::withHeaders(['key' => $apiKey])
                ->asForm()
                ->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                    'origin'      => $originId,
                    'destination' => $destinationCityId,
                    'weight'      => $weightGram,
                    'courier'     => $courier,
                ]);

            if (!$response->successful()) continue;

            $services = $response->json('data', []);
            foreach ($services as $svc) {
                $results[] = [
                    'courier'     => strtoupper($courier),
                    'service'     => $svc['service'] ?? '',
                    'description' => $svc['description'] ?? '',
                    'cost'        => $svc['cost'] ?? 0,
                    'etd'         => $svc['etd'] ?? '-',
                ];
            }
        }

        return $results ?: [['courier' => 'flat', 'service' => 'Reguler', 'description' => 'Flat Rate', 'cost' => 25000, 'etd' => '3-5 hari']];
    }

    // ── International (Shippo / Flat Zone) ──────────────────────────────────

    private function getInternationalOptions(string $country, int $weightGram): array
    {
        if (ApiSetting::isEnabled('shippo')) {
            $options = $this->getShippoRates($country, $weightGram);
            if (!empty($options)) return $options;
        }

        // Fallback: flat rate per zone
        $zone = ShippingZone::forCountry($country);
        $rate = $zone ? (float) $zone->flat_rate : 500000;
        $name = $zone ? $zone->name : 'International';

        return [['courier' => 'INTL', 'service' => $name, 'description' => 'International Shipping', 'cost' => $rate, 'etd' => '7-21 days']];
    }

    private function getShippoRates(string $country, int $weightGram): array
    {
        $token      = ApiSetting::get('shippo_api_key');
        $originZip  = ApiSetting::get('shippo_origin_zip', '60111');
        $originCountry = ApiSetting::get('shippo_origin_country', 'ID');

        // Create shipment
        $response = Http::withHeaders([
                'Authorization' => 'ShippoToken ' . $token,
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.goshippo.com/shipments/', [
                'address_from' => ['country' => $originCountry, 'zip' => $originZip],
                'address_to'   => ['country' => $this->countryToIso($country)],
                'parcels'      => [[
                    'length'        => '20',
                    'width'         => '20',
                    'height'        => '20',
                    'distance_unit' => 'cm',
                    'weight'        => round($weightGram / 1000, 2),
                    'mass_unit'     => 'kg',
                ]],
                'async' => false,
            ]);

        if (!$response->successful()) return [];

        $rates = $response->json('rates', []);
        $results = [];

        foreach (array_slice($rates, 0, 5) as $rate) {
            if (($rate['amount'] ?? 0) == 0) continue;
            $results[] = [
                'courier'     => $rate['provider'] ?? 'INTL',
                'service'     => $rate['servicelevel']['name'] ?? 'Standard',
                'description' => $rate['provider'] . ' ' . ($rate['servicelevel']['name'] ?? ''),
                'cost'        => (float) ($rate['amount'] ?? 0) * 16000, // USD to IDR approx
                'etd'         => ($rate['estimated_days'] ?? '?') . ' days',
                'shippo_rate_id' => $rate['object_id'] ?? null,
            ];
        }

        return $results;
    }

    private function countryToIso(string $countryName): string
    {
        // Common mappings — Shippo needs ISO 2-letter code
        $map = [
            'Indonesia' => 'ID', 'Malaysia' => 'MY', 'Singapore' => 'SG',
            'Thailand' => 'TH', 'Philippines' => 'PH', 'Vietnam' => 'VN',
            'Australia' => 'AU', 'Japan' => 'JP', 'South Korea' => 'KR',
            'China' => 'CN', 'India' => 'IN', 'United States' => 'US',
            'United Kingdom' => 'GB', 'Germany' => 'DE', 'France' => 'FR',
            'Netherlands' => 'NL', 'Canada' => 'CA', 'Brazil' => 'BR',
        ];

        return $map[$countryName] ?? 'US';
    }
}
