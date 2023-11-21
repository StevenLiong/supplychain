<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\logistic\Incoming;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IncomingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incoming::create([
            'kd_material_rak' => 1,
            'kd_supplier' => 2,
            'no_po' => 'P0001',
            'no_surat_jalan' => '0001',
            'batch_datang' => '1',
            'qty_kedatangan' => 10,
            'tgl_kedatangan' => '2023-01-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 1,
            'kd_supplier' => 2,
            'no_po' => 'P0001',
            'no_surat_jalan' => '0001',
            'batch_datang' => '1',
            'qty_kedatangan' => 10,
            'tgl_kedatangan' => '2023-01-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 2,
            'kd_supplier' => 2,
            'no_po' => 'P0002',
            'no_surat_jalan' => '0002',
            'batch_datang' => '2',
            'qty_kedatangan' => 20,
            'tgl_kedatangan' => '2023-01-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 3,
            'kd_supplier' => 1,
            'no_po' => 'P0003',
            'no_surat_jalan' => '0003',
            'batch_datang' => '3',
            'qty_kedatangan' => 30,
            'tgl_kedatangan' => '2023-02-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 6,
            'kd_supplier' => 1,
            'no_po' => 'P0004',
            'no_surat_jalan' => '0004',
            'batch_datang' => '4',
            'qty_kedatangan' => 40,
            'tgl_kedatangan' => '2023-03-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 5,
            'kd_supplier' => 2,
            'no_po' => 'P0005',
            'no_surat_jalan' => '0005',
            'batch_datang' => '5',
            'qty_kedatangan' => 50,
            'tgl_kedatangan' => '2023-03-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 6,
            'kd_supplier' => 2,
            'no_po' => 'P0006',
            'no_surat_jalan' => '0006',
            'batch_datang' => '6',
            'qty_kedatangan' => 60,
            'tgl_kedatangan' => '2023-03-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 2,
            'kd_supplier' => 3,
            'no_po' => 'P0007',
            'no_surat_jalan' => '0007',
            'batch_datang' => '7',
            'qty_kedatangan' => 70,
            'tgl_kedatangan' => '2023-04-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 6,
            'kd_supplier' => 2,
            'no_po' => 'P0008',
            'no_surat_jalan' => '0008',
            'batch_datang' => '6',
            'qty_kedatangan' => 60,
            'tgl_kedatangan' => '2023-05-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 6,
            'kd_supplier' => 2,
            'no_po' => 'P0009',
            'no_surat_jalan' => '0009',
            'batch_datang' => '6',
            'qty_kedatangan' => 60,
            'tgl_kedatangan' => '2023-06-22'
        ]);
        Incoming::create([
            'kd_material_rak' => 3,
            'kd_supplier' => 3,
            'no_po' => 'P0010',
            'no_surat_jalan' => '0010',
            'batch_datang' => '6',
            'qty_kedatangan' => 60,
            'tgl_kedatangan' => '2023-06-22'
        ]);
    }
}
