<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['author_id', 'title', 'slug', 'description', 'content', 'created_at', 'updated_at'])]
class Post extends Model
{
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->where('description', 'like', "%{$term}%")
                ->where('content', 'like', "%{$term}%");
        });
    }

    #[Scope]
    protected function byCategory(Builder $query, ?string $slug): Builder
    {
        if (!$slug || $slug === 'semua') {
            return $query;
        }

        return $query->whereHas('categories', fn ($q) => $q->where('slug', $slug));
    }
}
