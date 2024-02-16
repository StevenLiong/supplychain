<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csvFile = database_path('seeders\csv\man_hour.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('man_hours')->insert([
                'durasi_manhour' => $data['durasi_manhour'], // Sesuaikan dengan nama kolom Anda
                'id_work_center' => $data['id_work_center'], // Sesuaikan dengan nama kolom Anda
                'id_proses' => $data['id_proses'], // Sesuaikan dengan nama kolom Anda
                'id_tipe_proses' => $data['id_tipe_proses'], // Sesuaikan dengan nama kolom Anda
                'id_kapasitas' => $data['id_kapasitas'], // Sesuaikan dengan nama kolom Anda
                'id_kategori_produk' => $data['id_kategori_produk'], // Sesuaikan dengan nama kolom Anda
                'nama_workcenter' => $data['nama_workcenter'], // Sesuaikan dengan nama kolom Anda
                'nama_proses' => $data['nama_proses'], // Sesuaikan dengan nama kolom Anda
                'nama_tipeproses' => $data['nama_tipeproses'], // Sesuaikan dengan nama kolom Anda
                'ukuran_kapasitas' => $data['ukuran_kapasitas'], // Sesuaikan dengan nama kolom Anda
                'nama_kategoriproduk' => $data['nama_kategoriproduk'], // Sesuaikan dengan nama kolom Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}