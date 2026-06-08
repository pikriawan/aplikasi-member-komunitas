<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'sender_id',
    'conversation_id',
    'content',
)]
#[Appends([
    'date',
    'time',
])]
class Message extends Model
{
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    protected function date(): Attribute
    {
        $createdAt = $this->created_at->timezone(config('app.timezone'));
        $isToday = $createdAt->isCurrentDay();

        return Attribute::make(
            get: fn () => $isToday ? 'Hari ini' : $createdAt->format('j F o'),
        );
    }

    protected function time(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->timezone(config('app.timezone'))->format('G:i'),
        );
    }
}
