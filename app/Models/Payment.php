<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'invoice_id',
    'payer_id',
    'verifier_id',
    'payment_proof_url',
    'account_holder_name',
    'account_number',
    'account_bank_name',
    'reject_reason',
    'date',
)]
#[Appends([
    'long_date',
])]
class Payment extends Model
{
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->timezone(config('app.timezone'))->format('Y-m-d\TH:i') : null,
            set: fn ($value) => Carbon::createFromFormat('Y-m-d\TH:i', $value)->timezone(config('app.timezone'))->toDateTimeString(),
        );
    }

    protected function longDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date ? Carbon::parse($this->date)->timezone(config('app.timezone'))->format('d/m/Y H:i') : null,
        );
    }
}
