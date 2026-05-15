<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['uploader_id', 'type', 'title', 'file_url', 'thumbnail_url'])]
class Content extends Model
{
    public function uploader(): HasOne
    {
        return $this->hasOne(User::class, 'uploader_id');
    }

    #[Scope]
    protected function byType(Builder $query, ?string $type): Builder
    {
        if (!$type) {
            return $query;
        }

        return $query->where('type', $type);
    }
}
