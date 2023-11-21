<?php

namespace Database\Seeders;

use App\Models\logistic\Rak;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rak::create([
            'kd_rak' => 'A-01.1.1.L',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'A-01.1.1.R',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'A-01.1.2.L',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'A-01.1.2.R',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'A-01.1.3.L',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'A-01.1.3.R',
            'kd_gudang' => '1'
        ]);
    }
}
