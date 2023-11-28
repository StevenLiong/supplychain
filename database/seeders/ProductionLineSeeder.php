<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('production_line')->insert([
            'nama_pl' => 'PL2',
            'kapasitas_pl' => 52,
        ]);
        DB::table('production_line')->insert([
            'nama_pl' => 'PL3',
            'kapasitas_pl' => 10,
        ]);
        DB::table('production_line')->insert([
            'nama_pl' => 'CT/VT',
            'kapasitas_pl' => 0,
        ]);
        DB::table('production_line')->insert([
            'nama_pl' => 'DRY',
            'kapasitas_pl' => 8,
        ]);
        DB::table('production_line')->insert([
            'nama_pl' => 'REPAIR',
            'kapasitas_pl' => 0,
        ]);
    }
}
