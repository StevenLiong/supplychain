<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\planner\Mps;

class MpsSeeder extends Seeder
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
                'qty_trafo' => 2,
                'lead_time' => 9,
                'deadline' => '2023-11-20',
            ],
            [
                'id_wo' => '2',
                'project' => 'PT. Siemens',
                'production_line' => 'PL2',
                'kva' => '1000',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 2,
                'lead_time' => 11,
                'deadline' => '2023-11-23',
            ],
            [
                'id_wo' => '3',
                'project' => 'PT. Trafoindo Power Indonesia',
                'production_line' => 'PL3',
                'kva' => '2500',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 3,
                'lead_time' => 15,
                'deadline' => '2023-12-25',
            ],
            [
                'id_wo' => '4',
                'project' => 'PT. Symphos',
                'production_line' => 'PL2',
                'kva' => '250',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 1,
                'lead_time' => 8,
                'deadline' => '2023-12-10',
            ],
            [
                'id_wo' => '5',
                'project' => 'PT. Kolang Kaling',
                'production_line' => 'PL2',
                'kva' => '500',
                'jenis' => 'Trafo Oli',
                'qty_trafo' => 1,
                'lead_time' => 8,
                'deadline' => '2023-12-04',
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        foreach ($data as $mpsData) {
            Mps::create($mpsData);
        }
    }
}