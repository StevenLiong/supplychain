<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatriksSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = database_path('seeders\csv\matrix_skill3.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('matriks_skill')->insert([
                'id_mp' => $data['id_mp'],
                'id_production_line' => $data['id_production_line'],
                'id_kategori_produk' => $data['id_kategori_produk'],
                'id_proses' => $data['id_proses'],
                'id_tipe_proses' => $data['id_tipe_proses'],
                'skill' => $data['skill'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
