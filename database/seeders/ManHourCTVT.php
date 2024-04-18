<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManHourCTVT extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders\csv\man_hour_ctvt.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('man_hour_ct_vts')->insert([
                'durasi_manhour' => $data['durasi_manhour'],
                // 'id_work_center' => $data['id_work_center'],
                // 'id_proses' => $data['id_proses'],
                // 'id_tipe_proses' => $data['id_tipe_proses'],
                // 'id_kapasitas' => $data['id_kapasitas'],
                // 'id_kategori_produk' => $data['id_kategori_produk'],
                'nama_workcenter' => $data['nama_workcenter'],
                'nama_proses' => $data['nama_proses'],
                'nama_tipeproses' => $data['nama_tipeproses'],
                'ukuran_kapasitas' => $data['ukuran_kapasitas'],
                'nama_kategoriproduk' => $data['nama_kategoriproduk'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
