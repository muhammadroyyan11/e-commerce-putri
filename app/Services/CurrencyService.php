<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    const SUPPORTED = ['IDR', 'USD', 'EUR', 'SGD', 'MYR', 'GBP', 'AUD', 'JPY'];

    // Returns rate: 1 IDR = X target
    public function getRate(string $to): float
    {
        if ($to === 'IDR') return 1.0;

        $rates = Cache::remember('currency_rates', 3600, function () {
            $res = Http::timeout(5)->get('https://api.frankfurter.app/latest', [
                'from' => 'IDR',
                'to'   => implode(',', array_filter(self::SUPPORTED, fn($c) => $c !== 'IDR')),
            ]);
            return $res->successful() ? $res->json('rates', []) : [];
        });

        return $rates[$to] ?? 1.0;
    }

    public function convert(float $amountIdr, string $to): float
    {
        return $amountIdr * $this->getRate($to);
    }

    public function format(float $amountIdr, string $currency): string
    {
        $amount = $this->convert($amountIdr, $currency);

        return match ($currency) {
            'IDR'   => 'Rp ' . number_format($amount, 0, ',', '.'),
            'JPY'   => '¥' . number_format($amount, 0),
            'USD'   => '$' . number_format($amount, 2),
            'EUR'   => '€' . number_format($amount, 2),
            'GBP'   => '£' . number_format($amount, 2),
            default => $currency . ' ' . number_format($amount, 2),
        };
    }

    public function symbol(string $currency): string
    {
        return match ($currency) {
            'IDR' => 'Rp',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'SGD' => 'S$',
            'MYR' => 'RM',
            'AUD' => 'A$',
            default => $currency,
        };
    }

    public static function current(): string
    {
        return session('currency', 'IDR');
    }
}
