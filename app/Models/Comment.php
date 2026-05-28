<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'name', 'email', 'body'])]
class Comment extends Model
{
    /**
     * Relationship: A comment belongs to an article.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
