<?php

namespace Database\Seeders;

use App\Models\logistic\Gudang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gudang::create([
            'kd_gudang' => 'TR01',
            'nama_gudang' => 'Raw Material Trafo Oli'
        ]);
        Gudang::create([
            'kd_gudang' => 'DR01',
            'nama_gudang' => 'Raw Material Trafo Dry'
        ]);
        Gudang::create([
            'kd_gudang' => 'CR01',
            'nama_gudang' => 'Raw Material CTVT'
        ]);
        Gudang::create([
            'kd_gudang' => 'TF01',
            'nama_gudang' => 'Finishedgood Trafo'
        ]);
        Gudang::create([
            'kd_gudang' => 'CPCT',
            'nama_gudang' => 'Finishedgood CTVT'
        ]);
    }
}
