<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['query', 'ip_address'])]
class SearchLog extends Model
{
    // Disable default timestamps, we use custom created_at only
    public $timestamps = false;
}
