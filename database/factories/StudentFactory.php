<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'registration_number' => fake()->unique()->bothify('LIB-####-###'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'department' => fake()->randomElement(['Computer Science', 'Business', 'Literature', 'Science']),
        ];
    }
}
