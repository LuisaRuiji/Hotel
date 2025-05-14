<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',
        'floor',
        'price_per_night',
        'capacity',
        'description',
        'amenities',
        'status',
        'has_view',
        'is_smoking',
        'image_url'
    ];

    protected $casts = [
        'amenities' => 'array',
        'has_view' => 'boolean',
        'is_smoking' => 'boolean',
        'price_per_night' => 'decimal:2'
    ];
}
