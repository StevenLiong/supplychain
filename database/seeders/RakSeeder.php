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
            'kd_rak' => 'A-01.1.3.R',
            'kd_gudang' => '1'
        ]);
        Rak::create([
            'kd_rak' => 'B-01.1.1.R',
            'kd_gudang' => '2'
        ]);
        Rak::create([
            'kd_rak' => 'B-01.1.2.R',
            'kd_gudang' => '2'
        ]);
        Rak::create([
            'kd_rak' => 'B-01.1.3.R',
            'kd_gudang' => '2'
        ]);
        Rak::create([
            'kd_rak' => 'B-01.1.5.R',
            'kd_gudang' => '2'
        ]);
        Rak::create([
            'kd_rak' => 'B-01.1.6.R',
            'kd_gudang' => '2'
        ]);
        Rak::create([
            'kd_rak' => 'C-01.1.1.R',
            'kd_gudang' => '3'
        ]);
        Rak::create([
            'kd_rak' => 'C-01.1.1.R',
            'kd_gudang' => '3'
        ]);
        Rak::create([
            'kd_rak' => 'C-01.1.2.R',
            'kd_gudang' => '3'
        ]);
        Rak::create([
            'kd_rak' => 'C-01.1.3.R',
            'kd_gudang' => '3'
        ]);
    }
}
