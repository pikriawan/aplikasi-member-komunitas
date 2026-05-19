<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(
    'user_id',
    'number',
    'amount',
    'due_date',
    'status',
)]
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
}
