<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug'])]
class Tag extends Model
{
    /**
     * Relationship: A tag belongs to many articles.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
