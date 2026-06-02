<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);

        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'isbn' => fake()->unique()->isbn13(),
            'quantity' => $quantity,
            'available_copies' => $quantity,
            'shelf_location' => fake()->bothify('?##-##'),
            'status' => 'available',
        ];
    }
}
