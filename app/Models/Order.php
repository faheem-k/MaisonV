<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'city',
        'state',
        'postal_code',
        'country',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'coupon_code',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];
        return $statuses[$this->order_status] ?? 'secondary';
    }

    // Boot method for cascading deletes
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            // Delete related items and payments
            $order->items()->delete();
            $order->payment()->delete();
        });
    }
}
