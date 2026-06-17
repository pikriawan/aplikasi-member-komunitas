<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(
    'submitter_id',
)]
class Conversation extends Model
{
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitter_id');
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->whereHas('submitter', function (Builder $query) use ($term) {
            $query->where('name', 'like', "%{$term}%");
        });
    }
}
