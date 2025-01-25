<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weight;

class WeightSeeder extends Seeder
{
    public function run()
    {
        $weights = [
            ['name' => 'Standard', 'value' => 120, 'unit' => 'g'],
            ['name' => 'Heavy', 'value' => 140, 'unit' => 'g'],
            ['name' => 'Extra Heavy', 'value' => 160, 'unit' => 'g'],
            ['name' => 'Audiophile', 'value' => 180, 'unit' => 'g'],
            ['name' => 'Super Audiophile', 'value' => 200, 'unit' => 'g'],
        ];

        foreach ($weights as $weight) {
            Weight::create($weight);
        }
    }
}
