<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'address', 'city', 'province', 'postal_code', 'payment_method', 'payment_method_id',
        'status', 'subtotal', 'discount', 'shipping', 'total', 'notes'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentConfirmation()
    {
        return $this->hasOne(PaymentConfirmation::class);
    }

    public function scopePendingPayment($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAwaitingConfirmation($query)
    {
        return $query->where('status', 'awaiting_confirmation');
    }
}
