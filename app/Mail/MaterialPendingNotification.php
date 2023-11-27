<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaterialPendingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $idBom;
    public $material;

    public $stockInfo;
    public $subjekEmail;
    public $namaMaterialBom;
    public $usageMaterial;

    public function __construct($material, $stockInfo, $subjekEmail, $idBom)
    {
        $this->material = $material;
        $this->stockInfo = $stockInfo; // Menyimpan $stockInfo
        $this->subjekEmail = $subjekEmail;
        $this->idBom = $idBom;
    }

    public function build()
    {
        return $this->view('planner.bom.material-pending-notif')
            ->with([
                'idBom' => $this->idBom,
                'subjekEmail' => $this->subjekEmail,
                'material' => $this->material,
                'stockInfo' => $this->stockInfo, // Tambahkan ini jika $stockInfo telah diatur sebelumnya
            ]);
    }
}