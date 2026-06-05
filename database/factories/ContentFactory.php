<?php

namespace Database\Factories;

use App\Enums\ContentType;
use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => Str::title(fake()->sentence()),
            'type'      => fake()->randomElement(ContentType::cases()),
            'file_url'  => fake()->url(),
        ];
    }
}
