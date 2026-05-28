<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    /**
     * Retrieve a website setting by key dynamically with optional default fallback.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
