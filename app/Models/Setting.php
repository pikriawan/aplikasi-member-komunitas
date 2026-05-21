<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(
    'key',
    'value',
)]
class Setting extends Model
{
    public static function get(string $key, $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function allAsMap(): Collection
    {
        return static::all()->mapWithKeys(fn ($setting) => [
            $setting->key => $setting->value,
        ]);
    }
}
