<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandardizedWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 1,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 2,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 3,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 4,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
        ]);
    }
}