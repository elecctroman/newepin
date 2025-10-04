<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'provider',
        'status',
        'amount',
        'provider_response',
        'reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'provider_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
