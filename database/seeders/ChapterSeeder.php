<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data into 'chapters' table
        DB::table('chapters')->insert([
            [
                'label' => 'Chapter 1',
                'description' => 'Description of Chapter 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'Chapter 2',
                'description' => 'Description of Chapter 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more chapters as needed
        ]);
    }
}
