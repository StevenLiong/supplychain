<?php

namespace Database\Seeders;

use App\Models\produksi\Mps2;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Mps2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_wo' => '1',
                'project' => 'PT. PLN',
                'production_line' => 'PL2',
                'kva' => '1000',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 110,
                'lead_time' => 9,
                'deadline' => '2023-12-10',
            ],
            [
                'id_wo' => '2',
                'project' => 'PT. Siemens',
                'production_line' => 'PL3',
                'kva' => '1000',
                'jenis' => 'Dry',
                'qty_trafo' => 50,
                'lead_time' => 11,
                'deadline' => '2023-12-23',
            ],
            [
                'id_wo' => '3',
                'project' => 'PT. Trafoindo Power Indonesia',
                'production_line' => 'CTVT',
                'kva' => '2500',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 50,
                'lead_time' => 15,
                'deadline' => '2023-12-25',
            ],
            [
                'id_wo' => '4',
                'project' => 'PT. Symphos',
                'production_line' => 'DRY',
                'kva' => '250',
                'jenis' => 'D',
                'qty_trafo' => 10,
                'lead_time' => 8,
                'deadline' => '2023-12-10',
            ],
            [
                'id_wo' => '5',
                'project' => 'PT. Symphos',
                'production_line' => 'REPAIR',
                'kva' => '250',
                'jenis' => 'D',
                'qty_trafo' => 5,
                'lead_time' => 8,
                'deadline' => '2023-12-10',
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        foreach ($data as $mpsData) {
            Mps2::create($mpsData);
        }
    }
}
