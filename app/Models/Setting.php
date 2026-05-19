<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'manager_id',
    'key',
    'value',
)]
class Setting extends Model
{
    public static function get(string $key): mixed
    {
        return static::where('key', $key)->value('value');
    }

    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
