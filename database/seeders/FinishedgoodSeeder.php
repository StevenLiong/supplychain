<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\planner\Fgoods;

class FinishedgoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'nama_barang' => 'Trafo 1',
                'wo' => 'W111111',
                'nsk' => 'NSK111111',
                'nsp' => 'NSP111111',
                'kva' => 1000,
                'qty' => 4,
            ],
            [
                'kd_finishedgood' => 'TAE28AH0644201AAAW',
                'nama_barang' => 'Trafo 2',
                'wo' => 'W222222',
                'nsk' => 'NSK222222',
                'nsp' => 'NPS222222',
                'kva' => 500,
                'qty' => 30,
            ],
            [
                'kd_finishedgood' => 'TAE28AH0644201AAAC',
                'nama_barang' => 'Trafo 3',
                'wo' => 'WO333333',
                'nsk' => 'NSK333333',
                'nsp' => 'NSP666666',
                'kva' => 1600,
                'qty' => 6,
            ],
            [
                'kd_finishedgood' => 'TAE29AH0644201AAAW',
                'nama_barang' => 'Trafo 4',
                'wo' => 'WO444444',
                'nsk' => 'NSK444444',
                'nsp' => 'NSP444444',
                'kva' => 1500,
                'qty' => 5,
            ],
            [
                'kd_finishedgood' => 'TAE29AH0644201AAAC',
                'nama_barang' => 'Trafo 5',
                'wo' => 'WO555555',
                'nsk' => 'NSK5555555',
                'nsp' => 'NSP555555',
                'kva' => 800,
                'qty' => 4,
            ],
            [
                'kd_finishedgood' => 'TAE31AH0644201AAAW',
                'nama_barang' => 'Trafo 6',
                'wo' => 'WO666666',
                'nsk' => 'NSK666666',
                'nsp' => 'NSP666666',
                'kva' => 1600,
                'qty' => 6,
            ],
        ];

        foreach($data as $fgood){
            Fgoods::create($fgood);
        }
    }
}
