<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

#[Fillable([
    'user_id', 'slug', 'title', 'excerpt', 'content', 'category_id', 'image', 
    'read_time', 'views', 'is_headline', 'is_secondary_headline', 
    'reactions_suka', 'reactions_terkejut', 'reactions_inspiratif', 'reactions_sedih', 'status'
])]
class Article extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => \App\Enums\ContentStatus::class,
    ];

    /**
     * Get the author of the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the article.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all comments for the article.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all tags associated with the article.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Accessor to get Indonesian formatted date (e.g., "28 Mei 2026")
     */
    public function getFormattedDateAttribute(): string
    {
        Carbon::setLocale('id');
        return $this->created_at->translatedFormat('d F Y');
    }
}
