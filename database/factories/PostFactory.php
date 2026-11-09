<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
        $title = fake()->sentence(6);

        return [
            'category_id' => Category::factory(),
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'excerpt' => fake()->sentence(18),
            'body' => '<p>'.fake()->paragraph().'</p><p>'.fake()->paragraph().'</p>',
            'cover_image' => null,
            'status' => PostStatus::Draft,
            'is_featured' => false,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
