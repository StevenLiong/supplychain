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
                'nama_material' => 'Ins paper complete set',
                'satuan' => 'Kg',
                'jumlah' => 2000,
            ],
            [
                'kd_material' => 'RTB1991',
                'nama_material' => 'SMPC1',
                'satuan' => 'Pcs',
                'jumlah' => 4129,
            ],
            [
                'kd_material' => 'RTB1992',
                'nama_material' => 'SFP1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1993',
                'nama_material' => 'SFPC1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1994',
                'nama_material' => 'Bushing LV1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1995',
                'nama_material' => 'Bushing HV1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1996',
                'nama_material' => 'Stacking Core1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1997',
                'nama_material' => 'SMC1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1998',
                'nama_material' => 'Konek1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB1999',
                'nama_material' => 'Tangki Powerindo',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB2000',
                'nama_material' => 'SUPPMFAF1',
                'satuan' => 'Pcs',
                'jumlah' => 500,
            ],
            [
                'kd_material' => 'RTB2001',
                'nama_material' => 'Oven philip1',
                'satuan' => 'Pcs',
                'jumlah' => 765,
            ],
            [
                'kd_material' => 'RTB2002',
                'nama_material' => 'End game1',
                'satuan' => 'Pcs',
                'jumlah' => 534,
            ],
            [
                'kd_material' => 'RTB2003',
                'nama_material' => 'Ready SLOT1',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2004',
                'nama_material' => 'QC Trafo',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2005',
                'nama_material' => 'QCTRFGD',
                'satuan' => 'Pcs',
                'jumlah' => 513,
            ],
            [
                'kd_material' => 'RTB2006',
                'nama_material' => 'COre Coil',
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