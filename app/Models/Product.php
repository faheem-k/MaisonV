<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'category',
        'image',
        'sku',
        'stock',
        'is_active',
        'is_new',
        'is_sale',
        'featured',
        'rating',
        'reviews_count',
        'sizes',
        'colors',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'is_sale' => 'boolean',
        'featured' => 'boolean',
    ];

    // Relationships
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    // Accessors
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->price < $this->original_price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }
}
