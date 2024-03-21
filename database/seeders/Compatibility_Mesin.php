<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Compatibility_Mesin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders\csv\compatibility_mesin.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('compatibility_mesins')->insert([
                'nama_ms' => $data['nama_ms'],
                'production_line' => $data['production_line'],
                'nama_workcenter' => $data['nama_workcenter'],
                'proses' => $data['proses'],
                'tipe_proses' => $data['tipe_proses'],
                'skill' => $data['skill'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
