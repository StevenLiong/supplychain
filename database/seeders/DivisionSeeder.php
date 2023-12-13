<?php

namespace Database\Seeders;

use App\Models\purchaser\division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        division::create([
            'id_division' => '11122',
            'name_division' => 'TPP1-AFFAIR-PRODUKSI',
        ]);
        division::create([
            'id_division' => '11123',
            'name_division' => 'TPP2-AFFAIR-PRODUKSI',
        ]);
        division::create([
            'id_division' => '11124',
            'name_division' => 'TPP3-AFFAIR-PRODUKSI',
        ]);
        division::create([
            'id_division' => '11125',
            'name_division' => 'TPP4-AFFAIR-PRODUKSI',
        ]);
    }
}
