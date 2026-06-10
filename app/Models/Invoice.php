<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Carbon\Carbon;
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
    'long_date',
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

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (string $value, array $attributes) {
                if (now()->isAfter(Carbon::parse($attributes['due_date'])) && $value === InvoiceStatus::Unpaid->value) {
                    return InvoiceStatus::Canceled->value;
                }

                return $value;
            },
        );
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->timezone(config('app.timezone'))->format('d/m/Y H:i'),
        );
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
