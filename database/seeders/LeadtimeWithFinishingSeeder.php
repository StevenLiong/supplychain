<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadtimeWithFinishingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = database_path('seeders\csv\leadtime_withfinishing.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('leadtime_withfinishings')->insert([
                'kva' => $data['kva'], // Sesuaikan dengan nama kolom Anda
                'jeda_QCTransfer' => $data['jeda_QCTransfer'], // Sesuaikan dengan nama kolom Anda
                'jeda_QC' => $data['jeda_QC'], // Sesuaikan dengan nama kolom Anda
                'jeda_finishing' => $data['jeda_finishing'], // Sesuaikan dengan nama kolom Anda
                'jeda_confa' => $data['jeda_confa'], // Sesuaikan dengan nama kolom Anda
                'jeda_supmatconfa' => $data['jeda_supmatconfa'], // Sesuaikan dengan nama kolom Anda
                'jeda_susuncore' => $data['jeda_susuncore'], // Sesuaikan dengan nama kolom Anda
                'jeda_mould' => $data['jeda_mould'], // Sesuaikan dengan nama kolom Anda
                'jeda_supfixcore' => $data['jeda_supfixcore'], // Sesuaikan dengan nama kolom Anda
                'jeda_core' => $data['jeda_core'], // Sesuaikan dengan nama kolom Anda
                'jeda_hv' => $data['jeda_hv'], // Sesuaikan dengan nama kolom Anda
                'jeda_lv' => $data['jeda_lv'], // Sesuaikan dengan nama kolom Anda
                'jeda_supmatmould' => $data['jeda_supmatmould'], // Sesuaikan dengan nama kolom Anda
                'jeda_supmatinscoil' => $data['jeda_supmatinscoil'], // Sesuaikan dengan nama kolom Anda
                'jeda_inspaper' => $data['jeda_inspaper'], // Sesuaikan dengan nama kolom Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}