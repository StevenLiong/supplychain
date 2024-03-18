<?php

namespace Database\Seeders;

use App\Models\planner\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders\csv\holidays.csv'); // Tentukan jalur ke file CSV Anda

        $csvData = array_map('str_getcsv', file($csvFile));

        $header = array_shift($csvData); // Mengambil header

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);

            DB::table('holidays')->insert([
                'id' => $data['id'],
                'date' => $data['date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Contoh penambahan data hari libur
        // Holiday::create(['date' => '2024-01-01']); // Tambahkan tanggal hari libur
        // Holiday::create(['date' => '2024-02-08']); // Tambahkan tanggal hari libur lainnya
        // Holiday::create(['date' => '2024-02-09']);
        // Holiday::create(['date' => '2024-02-14']);
        // Holiday::create(['date' => '2024-03-11']);
        // Holiday::create(['date' => '2024-03-12']);
        // Holiday::create(['date' => '2024-03-29']);
        // Holiday::create(['date' => '2024-04-10']);
        // Holiday::create(['date' => '2024-04-11']);
        // Holiday::create(['date' => '2024-05-01']);
        // Holiday::create(['date' => '2024-05-09']);
        // Holiday::create(['date' => '2024-05-23']);
        // Holiday::create(['date' => '2024-06-01']);
        // Holiday::create(['date' => '2024-06-17']);
        // Holiday::create(['date' => '2024-07-07']);
        // Holiday::create(['date' => '2024-08-17']);
        // Holiday::create(['date' => '2024-09-16']);
        // Holiday::create(['date' => '2024-12-25']);
        // Tambahkan lebih banyak data hari libur sesuai kebutuhan
    }
}
