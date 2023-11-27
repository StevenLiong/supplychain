<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wo2s')->insert([
            'id_boms' => 1,
            'id_wo' => 1,
            'id_standardize_work' => 1,
            'qty_trafo' => 1,
            'id_so' => 1,
            'start_date' => '2023-11-24',
            'finish_date' => '2023-11-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('wo2s')->insert([
            'id_boms' => 1,
            'id_wo' => 2,
            'id_standardize_work' => 2,
            'qty_trafo' => 1,
            'id_so' => 1,
            'start_date' => '2023-11-24',
            'finish_date' => '2023-11-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('wo2s')->insert([
            'id_boms' => 1,
            'id_wo' => 3,
            'id_standardize_work' => 3,
            'qty_trafo' => 1,
            'id_so' => 1,
            'start_date' => '2023-11-24',
            'finish_date' => '2023-11-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('wo2s')->insert([
            'id_boms' => 1,
            'id_wo' => 4,
            'id_standardize_work' => 4,
            'qty_trafo' => 1,
            'id_so' => 1,
            'start_date' => '2023-11-24',
            'finish_date' => '2023-11-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
