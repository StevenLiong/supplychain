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
        $csvFile = database_path('seeders\csv\kapasitas_produksi1.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);
            // dd($data);

            DB::table('kapasitas_produksis')->insert([
                'tanggal' => $data['Tanggal'], // Sesuaikan dengan nama kolom Anda
                'pl2' => $data['PL1&Pl2'], // Sesuaikan dengan nama kolom Anda
                'pl3' => $data['PL3'], // Sesuaikan dengan nama kolom Anda
                'drytype' => $data['Drytype'],
                'oee_drytype' => $data['OEE Dry Type'],
                'oee_pl2' => $data['OEE PL1&PL2'],
                'oee_pl3' => $data['OEE PL3'],
                'output_drytype' => $data['Output/Hari Drytype'],
                'output_pl2' => $data['Output/Hari PL1&PL2'],
                'output_pl3' => $data['Output/Hari PL3'],
                'shift_kerja_drytype' => $data['Shift Kerja Drytype'],
                'shift_kerja_pl2' => $data['Shift Kerja PL1&PL2'],
                'shift_kerja_pl3' => $data['Shift Kerja PL3'],

                'jam_kerja_drytype' => $data['Jam Kerja Drytype'],
                'jam_kerja_pl2' => $data['Jam Kerja PL1&PL2'],
                'jam_kerja_pl3' => $data['Jam Kerja PL3'],

                'aktual_oee_drytype' => $data['Aktual OEE Drytype'],
                'aktual_oee_pl2' => $data['Aktual OEE PL1&PL2'],
                'aktual_oee_pl3' => $data['Aktual OEE PL3'],

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}