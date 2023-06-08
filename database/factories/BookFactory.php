<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->catchPhrase(),
            'description' => fake()->realText(),
            'year' => fake()->year(),
            'rating' => fake()->randomFloat(2, 0, 5),
            'price' => fake()->numberBetween(100, 2000),
            'date_added' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
