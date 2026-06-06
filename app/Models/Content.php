<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'uploader_id',
    'title',
    'type',
    'thumbnail_url',
    'file_url',
)]
#[Appends([
    'date',
])]
class Content extends Model
{
    use HasFactory;

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    #[Scope]
    protected function byType(Builder $query, ?string $type): Builder
    {
        if (!$type) {
            return $query;
        }

        return $query->where('type', $type);
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->timezone(config('app.timezone'))->format('j F o • g:i'),
        );
    }
}
