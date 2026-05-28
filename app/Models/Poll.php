<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['question', 'opt1', 'opt2', 'opt3', 'opt4', 'is_active'])]
class Poll extends Model
{
    /**
     * Scope a query to only include active polls.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
