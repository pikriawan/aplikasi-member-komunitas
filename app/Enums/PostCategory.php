<?php

namespace App\Enums;

enum PostCategory: string
{
    case News = 'news';
    case Event = 'event';

    public function label(): string
    {
        return match ($this) {
            self::News => 'Berita',
            self::Event => 'Acara',
        };
    }
}
