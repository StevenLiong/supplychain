<?php

namespace Database\Seeders;

use App\Models\logistic\Finishedgood;
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
        Finishedgood::create(
            [
                'kd_transfer' => 'T001',
                'id_wo' => 'W66666',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK11111',
                'nsp' => 'NSP111111',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 0
            ]
        );
        Finishedgood::create(
            [
                'kd_transfer' => 'T002',
                'id_wo' => 'W22222',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK22222',
                'nsp' => 'NSP22222',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 1
            ]
        );
        Finishedgood::create(
            [
                'kd_transfer' => 'T003',
                'id_wo' => 'W33333',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK33333',
                'nsp' => 'NSP33333',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 0
            ]
        );
        Finishedgood::create(
            [
                'kd_transfer' => 'T004',
                'id_wo' => 'W44444',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK44444',
                'nsp' => 'NSP44444',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 0
            ]
        );
        Finishedgood::create(
            [
                'kd_transfer' => 'T005',
                'id_wo' => 'W55555',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK55555',
                'nsp' => 'NSP55555',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 1
            ]
        );
        Finishedgood::create(
            [
                'kd_transfer' => 'T006',
                'id_wo' => 'W66666',
                'kd_finishedgood' => 'TAE24AH0644001JAAW',
                'kva' => 1000,
                'nsk' => 'NSK66666',
                'nsp' => 'NSP66666',
                'gudang' => 'Finishedgood Trafo',
                'qty' => 1,
                'status' => 0
            ]
        );
    }
}
