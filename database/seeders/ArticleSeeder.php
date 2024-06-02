<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create fake articles
        $faker = Faker::create();
        foreach (range(1, 15) as $index) {
            Article::create([
                'label' => $faker->sentence,
                'description' => $faker->paragraph,
            ]);
        }
    }
}

