<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name', 'position_id', 'position_en',
        'photo', 'bio_id', 'bio_en',
        'order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getPositionAttribute(): string
    {
        $lang = app()->getLocale();
        return $lang === 'en' ? $this->position_en : $this->position_id;
    }

    public function getBioAttribute(): ?string
    {
        $lang = app()->getLocale();
        return $lang === 'en' ? $this->bio_en : $this->bio_id;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
