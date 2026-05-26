<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'author_id',
    'category',
    'title',
    'slug',
    'summary',
    'content',
)]
class Post extends Model
{
    use HasFactory;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    #[Scope]
    protected function byCategory(Builder $query, ?string $category): Builder
    {
        if (!$category) {
            return $query;
        }

        return $query->where('category', $category);
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query
            ->where('title', 'like', "%{$term}%")
            ->orWhere('summary', 'like', "%{$term}%")
            ->orWhere('content', 'like', "%{$term}%");
    }
}
