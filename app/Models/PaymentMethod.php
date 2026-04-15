<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'account_name',
        'logo',
        'account_number',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} - {$this->account_number} a.n. {$this->account_name}";
    }

    public function isMidtrans(): bool
    {
        return $this->type === 'midtrans';
    }

    public function isManual(): bool
    {
        return $this->type === 'manual';
    }
}
