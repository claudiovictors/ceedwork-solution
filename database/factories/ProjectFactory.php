<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category' => fake()->randomElement(['Saúde', 'Educação', 'Eventos', 'Tecnologia']),
            'summary' => fake()->sentence(20),
            'description' => fake()->paragraphs(2, true),
            'logo' => null,
            'image' => null,
            'url' => fake()->url(),
            'technologies' => fake()->randomElements(
                ['Laravel', 'PHP', 'MySQL', 'Tailwind', 'Vue', 'React'],
                3
            ),
            'is_published' => true,
            'sort_order' => 0,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
