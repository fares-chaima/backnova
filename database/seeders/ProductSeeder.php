<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::factory()->count(20)->create();
        // Generate and insert 20 dummy products
        /*
        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'description' => 'Description for Product ' . $i,
                'quantity' => rand(5, 50), // Random quantity between 5 and 50
                'price' => rand(10, 1000) / 10, // Random price between 1 and 100
                'min' => rand(1, 10), // Random minimum quantity
                'fournisseur_id' => rand(1, 5), // Random fournisseur ID (assuming there are 5 fournisseurs)
                'article_id' => rand(1, 10), // Random article ID (assuming there are 10 articles)
            ]);
        }*/
    }
}
