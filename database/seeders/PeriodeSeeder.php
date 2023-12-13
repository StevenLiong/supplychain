<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periode')->insert([
            'nama_periode' => '1 Bulan',
            'jam_kerja' => '173',
        ]);
        DB::table('periode')->insert([
            'nama_periode' => '3 Minggu',
            'jam_kerja' => '120',
        ]);
        DB::table('periode')->insert([
            'nama_periode' => '2 Minggu',
            'jam_kerja' => '80',
        ]);
        DB::table('periode')->insert([
            'nama_periode' => '1 Minggu',
            'jam_kerja' => '40',
        ]);
    }
}
