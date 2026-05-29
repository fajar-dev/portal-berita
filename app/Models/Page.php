<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'slug', 'content', 'css', 'builder_data', 'is_active'])]
class Page extends Model
{
    // No extra relations needed for general custom pages
}
