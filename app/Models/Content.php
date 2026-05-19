<?php

namespace App\Models;

use App\Enums\ContentType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'uploader_id',
    'title',
    'type',
    'thumbnail_url',
    'file_url',
)]
class Content extends Model
{
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    #[Scope]
    protected function byType(Builder $query, ?ContentType $type): Builder
    {
        if (!$type) {
            return $query;
        }

        return $query->where('type', $type);
    }
}
