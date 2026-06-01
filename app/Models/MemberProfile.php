<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'user_id',
    'expired_date',
    'institution',
    'department',
    'address',
    'image_url',
    'is_active',
)]
class MemberProfile extends Model
{
    protected function casts(): array
    {
        return [
            'expired_date' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
