<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = ['name', 'countries', 'flat_rate', 'is_active', 'sort_order'];

    protected $casts = [
        'countries' => 'array',
        'flat_rate'  => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public static function forCountry(string $country): ?self
    {
        return static::where('is_active', true)
            ->get()
            ->first(fn($zone) => in_array($country, $zone->countries ?? []));
    }
}
