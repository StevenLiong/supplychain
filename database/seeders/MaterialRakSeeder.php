<?php

namespace Database\Seeders;

use App\Models\logistic\MaterialRak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialRakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 1,
            'qty_rak' => 80
        ]);
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 1,
            'qty_rak' => 870
        ]);
        MaterialRak::create([
            'material_id' => 8,
            'rak_id' => 4,
            'qty_rak' => 810
        ]);
        MaterialRak::create([
            'material_id' => 5,
            'rak_id' => 8,
            'qty_rak' => 830
        ]);
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 4,
            'qty_rak' => 80
        ]);
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 4,
            'qty_rak' => 3
        ]);
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 8,
            'qty_rak' => 700
        ]);
        MaterialRak::create([
            'material_id' => 1,
            'rak_id' => 8,
            'qty_rak' => 900
        ]);
    }
}
