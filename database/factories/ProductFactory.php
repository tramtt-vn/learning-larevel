<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10000, 5000000),
            'image' => 'products/default.jpg',
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
?>
