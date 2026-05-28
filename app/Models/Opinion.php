<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'excerpt', 'author', 'author_avatar', 'role', 'published_date'])]
class Opinion extends Model
{
    //
}
