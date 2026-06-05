<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
#[Appends([
    'number',
    'is_active',
    'join_date',
    'membership_until',
])]
class MemberProfile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'expired_date' => 'datetime',
        ];
    }

    protected function number(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::padLeft($this->id, 5, '0'),
        );
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expired_date->isFuture(),
        );
    }

    protected function joinDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->timezone(config('app.timezone'))->format('d F Y'),
        );
    }

    protected function membershipUntil(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expired_date->timezone(config('app.timezone'))->format('d F Y'),
        );
    }
}
