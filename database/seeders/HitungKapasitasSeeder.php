<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\planner\Hitung_kapasitas;
use Illuminate\Database\Seeder;

class HitungKapasitasSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_pl' => 'DryType',
                'oee' => 0.93,
                'output' => 2,
                'shift_kerja' => 1,
                'jam_kerja' => 8,
                'aktual_oee' => 0.75,
            ],
            [
                'nama_pl' => 'Pl1&2',
                'oee' => 0.93,
                'output' => 100,
                'shift_kerja' => 1,
                'jam_kerja' => 8,
                'aktual_oee' => 0.75,
            ],
            [
                'nama_pl' => 'Pl3',
                'oee' => 0.93,
                'output' => 6,
                'shift_kerja' => 1,
                'jam_kerja' => 8,
                'aktual_oee' => 0.75,
            ],
        ];

        foreach ($data as $hitungkapData) {
            Hitung_kapasitas::create($hitungkapData);
        }
    }
}