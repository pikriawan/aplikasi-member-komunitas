<?php

namespace Database\Factories;

use App\Enums\PostCategory;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->sentence());
        $slug = Str::slug($title);

        return [
            'category'  => fake()->randomElement(PostCategory::class),
            'title'     => $title,
            'slug'      => $slug,
            'summary'   => fake()->paragraph(),
            'content'   => '<p>' . fake()->paragraph() . '</p>' . '<p>' . fake()->paragraph() . '</p>' . '<p>' . fake()->paragraph() . '</p>',
        ];
    }
}
