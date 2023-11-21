<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\logistic\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'kd_supplier' => 'CHA.003.00',
            'nama_supplier' => 'CHARISMA TATAMITRA ABADI, PT',
            'email' => 'charisma@gmail.com',
            'alamat' => 'JL AMPERA RAYA NO 17, GRH AMPERA LT 6, JAKARTA',
        ]);
        Supplier::create([
            'kd_supplier' => 'CIP.001.00',
            'nama_supplier' => 'CV CIPTA BAHARI UTAMA',
            'email' => 'cipta@gmail.com',
            'alamat' => 'JL RAYA CIATER, BSD NO 41, TANGERANG 15416',
        ]);
        Supplier::create([
            'kd_supplier' => 'CIT.001.00',
            'nama_supplier' => 'CITRA BARU PERKASA, PT',
            'email' => 'citra@gmail.com',
            'alamat' => 'JL RAYA KEBAYORAN LAMA NO 23, RT 7 RW 2 SUKABUMI SELATAN, KEBON JERUK, JAKBAR 11560',
        ]);
        Supplier::create([
            'kd_supplier' => 'SUM.001.00',
            'nama_supplier' => 'CV SUMBER MAKMUR',
            'email' => 'sumber@gmail.com',
            'alamat' => 'GEDUNG METRO GLODOK, JL BLUSTRU NO 15-16-41, JAKARTA',
        ]);
        Supplier::create([
            'kd_supplier' => 'SUM.002.00',
            'nama_supplier' => 'SUMBER REJEKI TEKNIK, CV',
            'email' => 'rejeki@gmail.com',
            'alamat' => 'JL. CAMAN RAYA NO.25, JATIBENING II, BEKASI 17412',
        ]);
        Supplier::create([
            'kd_supplier' => 'SUM.003.00',
            'nama_supplier' => 'PT SUMBERDAYA SINAR BARU',
            'email' => 'daya@gmail.com',
            'alamat' => 'JL BANDENGAN UTARA TERUSAN 47, (JL BIDARA RAYA NO 1), JAKARTA 14450',
        ]);
        
    }
}
