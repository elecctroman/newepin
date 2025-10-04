<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'type',
        'price',
        'supplier',
        'api_product_id',
        'stock_count',
        'auto_deliver',
        'meta',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'auto_deliver' => 'boolean',
        'meta' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            $product->slug ??= Str::slug($product->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
