<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['poll_id', 'option_key', 'ip_address'])]
class PollVote extends Model
{
    // Disable default timestamps, we use custom created_at only
    public $timestamps = false;
}
