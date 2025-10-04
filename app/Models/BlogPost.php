<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'meta', 'is_published', 'published_at'];

    protected $casts = [
        'meta' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post) {
            $post->slug ??= Str::slug($post->title);
        });
    }
}
