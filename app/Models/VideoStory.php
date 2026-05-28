<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['slug', 'title', 'image', 'duration'])]
class VideoStory extends Model
{
    //
}
