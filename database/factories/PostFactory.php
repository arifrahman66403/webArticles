<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $title = fake()->sentence(),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'author_id' => User::query()->inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'category_id' => Category::query()->inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'photo' => null,
            'body' => collect(range(1, 5))
                ->map(fn () => implode(' ', fake()->words(100)))
                ->implode("\n\n"),
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
