<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\planner\Detailbom;
use App\Models\planner\Stock;
use App\Models\planner\Material;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialPendingNotification;

class EmailReminderTask extends Command
{
    protected $signature = 'email:reminder';
    protected $description = 'Send email reminders for materials';

    public function handle()
    {
        $this->info('Email reminders task started.');

        // Ambil data dari database
        $materials = Detailbom::where('db_status', 0)
            ->where('email_status', 0)
            ->get();

        // Proses setiap material
        foreach ($materials as $material) {
            // Dapatkan informasi stok dan material
            $stockInfo = Stock::where('item_code', $material->id_materialbom)->first();
            $materialInfo = Material::where('kd_material', $material->id_materialbom)->first();

            // Set email delay berdasarkan supplier
            $emailDelay = (strtolower($stockInfo->supplier) == 'lokal') ? 2 : 7;

            // Periksa apakah sudah lewat waktu tertentu sejak terakhir kali email dikirim
            if ($material->last_kirim_email === null || optional($material->last_kirim_email)->diffInDays(now()) >= $emailDelay) {
                // Kirim email
                $this->sendEmail($material, $stockInfo, $materialInfo);
                
                // Update status email dan timestamp
                $material->update(['email_status' => 1, 'last_kirim_email' => now()]);
            }
        }

        $this->info('Email reminders task completed.');
    }

    private function sendEmail($material, $stockInfo, $materialInfo)
    {
        $subjekEmail = "Bill of Material Tertunda " . $material->id_boms;

        // Kumpulkan semua informasi dari $material
        $dataMaterial = [
            'id_boms' => $material->id_boms,
            'id_materialbom' => $material->id_materialbom,
            'nama_materialbom' => $material->nama_materialbom,
            'usage_material' => $material->usage_material,
        ];

        // Kirim email ke alamat yang ditentukan
        $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
        Mail::to($alamatEmailPenerima)->send(new MaterialPendingNotification(
            collect([$dataMaterial]),
            $stockInfo,
            $subjekEmail,
            $material->id_boms,
            $materialInfo
        ));
    }
}
