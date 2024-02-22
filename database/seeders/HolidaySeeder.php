<?php

namespace Database\Seeders;

use App\Models\planner\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh penambahan data hari libur
        Holiday::create(['date' => '2024-01-01']); // Tambahkan tanggal hari libur
        Holiday::create(['date' => '2024-02-08']); // Tambahkan tanggal hari libur lainnya
        Holiday::create(['date' => '2024-02-09']);
        Holiday::create(['date' => '2024-02-14']);
        Holiday::create(['date' => '2024-03-11']);
        Holiday::create(['date' => '2024-03-12']);
        Holiday::create(['date' => '2024-03-29']);
        Holiday::create(['date' => '2024-04-10']);
        Holiday::create(['date' => '2024-04-11']);
        Holiday::create(['date' => '2024-05-01']);
        Holiday::create(['date' => '2024-05-09']);
        Holiday::create(['date' => '2024-05-23']);
        Holiday::create(['date' => '2024-06-01']);
        Holiday::create(['date' => '2024-06-17']);
        Holiday::create(['date' => '2024-07-07']);
        Holiday::create(['date' => '2024-08-17']);
        Holiday::create(['date' => '2024-09-16']);
        Holiday::create(['date' => '2024-12-25']);
        // Tambahkan lebih banyak data hari libur sesuai kebutuhan
    }
}