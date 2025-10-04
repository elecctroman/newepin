<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            $category->slug ??= Str::slug($category->name);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
