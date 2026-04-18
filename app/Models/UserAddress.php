<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone',
        'address', 'city', 'province', 'postal_code', 'country', 'is_primary',
    ];

    protected $casts = ['is_primary' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
