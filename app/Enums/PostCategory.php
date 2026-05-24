<?php

namespace App\Enums;

enum PostCategory: string
{
    case All = '';
    case News = 'news';
    case Event = 'event';

    public static function entries()
    {
        return array_map(fn ($item) => $item->toArray(), self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::All => 'Semua',
            self::News => 'Berita',
            self::Event => 'Acara',
        };
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'label' => $this->label(),
        ];
    }
}
