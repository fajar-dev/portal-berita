<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'ip_address', 'user_agent'])]
class ArticleView extends Model
{
    // Disable default timestamps, we use custom created_at only
    public $timestamps = false;

    /**
     * Relationship: An article view belongs to an article.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
