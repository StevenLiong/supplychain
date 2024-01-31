<?php

namespace Database\Seeders;

use App\Models\planner\KapasitasProduksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KapasitasProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = database_path('seeders\csv\kapasitas_produksi.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('kapasitas_produksis')->insert([
                'tanggal' => $data['tanggal'], // Sesuaikan dengan nama kolom Anda
                'PL2' => $data['PL2'], // Sesuaikan dengan nama kolom Anda
                'PL3' => $data['PL3'], // Sesuaikan dengan nama kolom Anda
                'Drytype' => $data['Drytype'], // Sesuaikan dengan nama kolom Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}