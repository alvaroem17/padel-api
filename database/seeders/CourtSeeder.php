<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       foreach (range(1,4) as $i) {
        \App\Models\Court::create([
            'name' => "Pista $i"
        ]);
        }
    }
}
