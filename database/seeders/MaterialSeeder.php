<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\planner\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'kd_material' => 'RTB1990',
                'nama_material' => 'Material 1',
                'satuan' => 'Kg',
                'jumlah' => 2000,
            ],
            [
                'kd_material' => 'RTB1991',
                'nama_material' => 'Material 2',
                'satuan' => 'Pcs',
                'jumlah' => 412,
            ],
            [
                'kd_material' => 'RTB1992',
                'nama_material' => 'Material 3',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1993',
                'nama_material' => 'Material 4',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1994',
                'nama_material' => 'Material 5',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1995',
                'nama_material' => 'Material 6',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1996',
                'nama_material' => 'Material 7',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1997',
                'nama_material' => 'Material 8',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1998',
                'nama_material' => 'Material 9',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1999',
                'nama_material' => 'Material 10',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB2000',
                'nama_material' => 'Material 11',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB2001',
                'nama_material' => 'Material 12',
                'satuan' => 'Pcs',
                'jumlah' => 765,
            ],
            [
                'kd_material' => 'RTB2002',
                'nama_material' => 'Material 13',
                'satuan' => 'Pcs',
                'jumlah' => 534,
            ],
            [
                'kd_material' => 'RTB2003',
                'nama_material' => 'Material 14',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2004',
                'nama_material' => 'Material 15',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2005',
                'nama_material' => 'Material 16',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2006',
                'nama_material' => 'Material 17',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        foreach ($data as $materialData) {
            Material::create($materialData);
        }
    }
}