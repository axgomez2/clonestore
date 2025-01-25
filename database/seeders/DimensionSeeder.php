<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dimension;

class DimensionSeeder extends Seeder
{
    public function run()
    {
        $dimensions = [
            ['name' => '7"', 'height' => 7, 'width' => 7, 'depth' => 0.07, 'unit' => 'cm'],
            ['name' => '10"', 'height' => 10, 'width' => 10, 'depth' => 0.07, 'unit' => 'cm'],
            ['name' => '12"', 'height' => 12, 'width' => 12, 'depth' => 0.07, 'unit' => 'cm'],
            ['name' => 'LP', 'height' => 12, 'width' => 12, 'depth' => 0.07, 'unit' => 'cm'],
            ['name' => 'EP', 'height' => 7, 'width' => 7, 'depth' => 0.07, 'unit' => 'cm'],
        ];

        foreach ($dimensions as $dimension) {
            Dimension::create($dimension);
        }
    }
}
