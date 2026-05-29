<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'color', 'order'])]
class Category extends Model
{
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
