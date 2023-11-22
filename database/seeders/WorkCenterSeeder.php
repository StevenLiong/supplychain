<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = database_path('seeders\csv\work_center.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('work_centers')->insert([
                'nama_work_center' => $data['nama_work_center'], // Sesuaikan dengan nama kolom Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
