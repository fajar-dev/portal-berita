<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'excerpt', 'author', 'author_avatar', 'role', 'published_date', 'status'])]
class Opinion extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => \App\Enums\ContentStatus::class,
    ];
}
