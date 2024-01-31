<?php

namespace Database\Seeders;

use App\Models\planner\KapasitasProduksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KapasitasProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tanggal' => '2024-01-01',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-02',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-03',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-04',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-05',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-06',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-07',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-08',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-09',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-10',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-11',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-12',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-13',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-14',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-15',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-16',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-17',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-18',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-19',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-20',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-21',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-22',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-23',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-24',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-25',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-26',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-27',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-28',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-29',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-30',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            [
                'tanggal' => '2024-01-31',
                'PL2' => '93',
                'PL3' => '6',
                'Drytype' => '2',
            ],
            
        ];
        
        foreach($data as $kapasitasProduksi){
            KapasitasProduksi::create($kapasitasProduksi);
        }
    }
}