<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders\csv\mesin.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('mesin')->insert([
                'kode_aset' => $data['kode_aset'],
                'nama_mesin' => $data['nama_mesin'],
                'merk_mesin' => $data['merk_mesin'],
                'id_production_line' => $data['id_production_line'],
                'id_work_centers' => $data['id_work_centers'],
                'kva_min' => $data['kva_min'],
                'kva_max' => $data['kva_max'],
                'output' => $data['output'],
                'status' => $data['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
