<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'currency',
        'transaction_id',
        'status',
        'response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response' => 'array',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
