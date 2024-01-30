<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jam_kerja')->insert([
            'jam_kerja' => 'Harian',
            'total_jam_kerja' => '8',
        ]);
        DB::table('jam_kerja')->insert([
            'jam_kerja' => 'Mingguan',
            'total_jam_kerja' => '40',
        ]);
        DB::table('jam_kerja')->insert([
            'jam_kerja' => 'Bulanan',
            'total_jam_kerja' => '173',
        ]);
    }
}
