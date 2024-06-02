<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'description' => $this->faker->paragraph(),
            'quantity' => rand(5, 50), // Random quantity between 5 and 50
            'price' => rand(10, 1000) / 10, // Random price between 1 and 100
            'min' => rand(1, 10), // Random minimum quantity
            //'fournisseur_id' => rand(1, 5), // Random fournisseur ID (assuming there are 5 fournisseurs)
            // 'article_id' => rand(1,5)
        ];
    }
}
