<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[Fillable(
    'user_id',
    'amount',
    'due_date',
    'status',
)]
#[Appends([
    'number',
    'long_date'
])]
class Invoice extends Model
{
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function number(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::padLeft($this->id, 5, '0'),
        );
    }

    protected function longDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i'),
        );
    }
}
