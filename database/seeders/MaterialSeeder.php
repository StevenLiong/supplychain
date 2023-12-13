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
                'kd_material' => 'RDB3C0613',
                'nama_material' => 'Copper Sheet 1.20 x 710 mm',
                'satuan' => 'Kg',
                'jumlah' => 3268,
            ],
            [
                'kd_material' => 'RDB3C0695',
                'nama_material' => 'Copper Sheet 0.80 x 710 mm',
                'satuan' => 'Kg',
                'jumlah' => 999,
            ],
            [
                'kd_material' => 'RDB3I0308',
                'nama_material' => 'Insulation Spacer Strips 6x8x3500',
                'satuan' => 'Pcs',
                'jumlah' => 2130,
            ],
            [
                'kd_material' => 'RDB3I0350',
                'nama_material' => 'Insulation Spacer Strips',
                'satuan' => 'Pcs',
                'jumlah' => 456,
            ],
            [
                'kd_material' => 'RDB3C0801',
                'nama_material' => 'No Alkali Wax Glass Fiber Tape 0.16 x 50 (Cotton Band Fiber)',
                'satuan' => 'Roll',
                'jumlah' => 702,
            ],
            [
                'kd_material' => 'RDB3S2188',
                'nama_material' => 'V-Notch Core S3/23/0054 1500kVA',
                'satuan' => 'Kg',
                'jumlah' => 2000,
            ],
            [
                'kd_material' => 'SFPC',
                'nama_material' => 'Supply Material dari WC Core',
                'satuan' => 'Bh',
                'jumlah' => 5000,
            ],
            [
                'kd_material' => 'RDB3Z2279',
                'nama_material' => 'Fixing Part + Cat Hitam',
                'satuan' => 'Set',
                'jumlah' => 5000,
            ],
            [
                'kd_material' => 'SC',
                'nama_material' => 'Susun Core dari WC Core',
                'satuan' => 'Bh',
                'jumlah' => 5000,
            ],
            [
                'kd_material' => 'SMCFA',
                'nama_material' => 'SMCFA',
                'satuan' => 'Bh',
                'jumlah' => 5000,
            ],
            [
                'kd_material' => 'RDB3T0004',
                'nama_material' => 'Temperature Measure Point',
                'satuan' => 'Pcs',
                'jumlah' => 765,
            ],
            [
                'kd_material' => 'RTBB14987',
                'nama_material' => 'Baut Din 8.8 M16 x 50 mm (Galvanis Putih)',
                'satuan' => 'Pcs',
                'jumlah' => 124,
            ],
            [
                'kd_material' => 'RZBM04022',
                'nama_material' => 'Mur / Nut Din 8.8 M16 (Galvanis Putih)',
                'satuan' => 'Pcs',
                'jumlah' => 286,
            ],
            [
                'kd_material' => 'RZBR06017',
                'nama_material' => 'Ring Plat Din 8.8 M16 (Galvanis Putih)',
                'satuan' => 'Pcs',
                'jumlah' => 412,
            ],
            [
                'kd_material' => 'RZBR02015',
                'nama_material' => 'Rail Copper 8t x 100 mm',
                'satuan' => 'Cm',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RZBR07017',
                'nama_material' => 'Ring Plat Din 8.8 M12 (Galvanis Putih)',
                'satuan' => 'Pcs',
                'jumlah' => 546,
            ],
        ];

        foreach ($data as $materialData) {
            Material::create($materialData);
        }
    }
}