<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\fournisseur;
class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert dummy data into the fournisseurs table
        for ($i = 1; $i <= 20; $i++) {
            DB::table('fournisseurs')->insert([
                'firstname' => 'Fournisseur ' . $i,
                'lastname' => 'Lastname ' . $i,
                'adresse' => 'Adresse ' . $i,
                'number' => rand(10000000, 99999999),
                'email' => 'fournisseur' . $i . '@example.com',
                'bio' => 'Bio for fournisseur ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

