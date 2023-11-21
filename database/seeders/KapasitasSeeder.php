<?php

namespace Database\Seeders;

use App\Models\kapasitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KapasitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $csvFile = database_path('seeders\csv\kapasitas.csv'); // Tentukan jalur ke file CSV Anda

    //     $csvData = array_map('str_getcsv', file($csvFile));

    //     foreach ($csvData as $row) {
    //         DB::table('kapasitas')->insert([
    //             'ukuran_kapasitas' => $row[0], // Ganti dengan nama kolom Anda
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }
    // }

    public function run()
    {
        $csvFile = database_path('seeders\csv\kapasitas.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('kapasitas')->insert([
                'ukuran_kapasitas' => $data['ukuran_kapasitas'], // Sesuaikan dengan nama kolom Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
