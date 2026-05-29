<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'position',
        'image_url',
        'target_url',
        'is_active',
    ];

    protected $casts = [
        'position' => \App\Enums\AdPosition::class,
    ];
}
