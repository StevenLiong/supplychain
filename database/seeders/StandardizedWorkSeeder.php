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
            'total_hour' => 100,
            'id_fg' => 'FG1111',
            'kd_manhour' => 'MH1111',
            'nama_product' => 'Dry Cast Resin'
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 2,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
            'total_hour' => 50,
            'id_fg' => 'FG2222',
            'kd_manhour' => 'MH2222',
            'nama_product' => 'Dry Cast Resin'
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 3,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
            'total_hour' => 5,
            'id_fg' => 'FG3333',
            'kd_manhour' => 'MH3333',
            'nama_product' => 'Dry Cast Resin'
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => 4,
            'id_dry_non_resin' => null,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
            'total_hour' => 20,
            'id_fg' => 'FG4444',
            'kd_manhour' => 'MH4444',
            'nama_product' => 'Dry Cast Resin'
        ]);
        DB::table('standardize_works')->insert([
            'id_dry_cast_resin' => NULL,
            'id_dry_non_resin' => 1,
            'id_oil_standard' => null,
            'id_oil_custom' => null,
            'id_ct' => null,
            'id_vt' => null,
            'id_repair' => null,
            'total_hour' => 15,
            'id_fg' => 'FG5555',
            'kd_manhour' => 'MH5555',
            'nama_product' => 'Dry Non Resin'
        ]);
    }
}
