<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'parent_id', 'user_id', 'name', 'email', 'body'])]
class Comment extends Model
{
    /**
     * Relationship: A comment belongs to an article.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relationship: A comment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A comment can have many replies.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Relationship: A comment belongs to a parent comment (if it is a reply).
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
