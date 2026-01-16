<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 10, 2000),
            'in_stock' => fake()->boolean(80), // 80% товаров в наличии
            'rating' => fake()->randomFloat(1, 0, 5),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
