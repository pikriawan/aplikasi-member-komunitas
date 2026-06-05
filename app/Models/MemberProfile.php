<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'user_id',
    'expired_date',
    'gender',
    'blood_type',
    'last_education',
    'institution',
    'department',
    'address',
    'image_url',
)]
class MemberProfile extends Model
{
    protected function casts(): array
    {
        return [
            'expired_date' => 'datetime',
        ];
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expired_date->isFuture(),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
