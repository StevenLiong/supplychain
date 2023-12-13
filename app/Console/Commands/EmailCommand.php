<?php
namespace App\Console\Commands;
use App\Models\planner\Detailbom; // Adjust namespace and model accordingly
use App\Models\planner\Stock;
use App\Models\planner\Material;
use App\Mail\MaterialPendingNotification;
use App\Models\purchaser\pesanan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class EmailCommand extends Command
{
    protected $signature = 'email:reminder';
    protected $description = 'Send email reminders for pending materials';
    public function handle()
    {
        $pendingMaterials = Detailbom::where('db_status', 0)
            ->where('email_status', 1)
            ->get();
    
        if ($pendingMaterials->count() > 0) {
            foreach ($pendingMaterials as $material) {
                $stockInfo = Stock::where('item_code', $material->id_materialbom)->first();
    
                $this->info("email_status: {$material->email_status}, db_status: {$material->db_status}, supplier: {$stockInfo->supplier}, last_kirim_email: {$material->last_kirim_email}");
    
                // Perbarui logika untuk menangani situasi last_kirim_email kosong
                $emailDelay = 0;
                if (!is_null($material->last_kirim_email)) {
                    $emailDelay = (strtolower($stockInfo->supplier) == 'lokal') ? 2 : 7;
                }
    
                $daysDifference = now()->diffInDays($material->last_kirim_email);
                $this->info("Selisih hari: " . $daysDifference . ", emailDelay: {$emailDelay}");
    
                if ($daysDifference >= $emailDelay) {
                    $this->info('Condition met. Calling sendEmailReminder.');
                    $this->sendEmailReminder($material);
                    $material->update(['last_kirim_email' => now()]);
                } else {
                    $this->info('Condition not met. Skipping sendEmailReminder.');
                }                
            }
        } else {
            $this->info('No pending materials found with email_status = 1.');
        }
    
        $this->info('Email reminder task completed.');
    }

    protected function sendEmailReminder($material)
    {
        $subjekEmail = "Reminder: Bill of Material Tertunda {$material->id_boms}";
        $dataMaterial = [
            'id_boms' => $material->id_boms,
            'id_materialbom' => $material->id_materialbom,
            'nama_materialbom' => $material->nama_materialbom,
            'usage_material' => $material->usage_material,
        ];

        $stockInfo = Stock::where('item_code', $material->id_materialbom)->first();
        $pesananInfo = pesanan::where('kd_material', $material->id_materialbom)->first();
        $materialInfo = Material::where('kd_material', $material->id_materialbom)->first();

        $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
        Mail::to($alamatEmailPenerima)->send(new MaterialPendingNotification(
            collect([$dataMaterial]),
            $stockInfo,
            $subjekEmail,
            $material->id_boms,
            $materialInfo,
            $pesananInfo
        ));

        $material->update(['email_status' => 1, 'last_kirim_email' => now()]);
        $this->info('Email reminder task completed111.');

    }
}
