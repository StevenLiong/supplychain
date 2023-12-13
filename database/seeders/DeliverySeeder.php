<?php

namespace Database\Seeders;

use App\Models\purchaser\delivery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       delivery::create([
            'id_delivery' => 'TPP1',
            'alamat' => 'JL HAYAM WURUK FX 4',
        ]);
        delivery::create([
            'id_delivery' => 'TPP2',
            'alamat' => 'JL PRABU SILIWANGI RT 06/04',
        ]);
        delivery::create([
            'id_delivery' => 'TPP3',
            'alamat' => 'JL PRABU SILIWANGI RT 04/01',
        ]);
        delivery::create([
            'id_delivery' => 'TPP4',
            'alamat' => 'JL PRABU SILIWANGI RT 01/01',
        ]);
    }
}
