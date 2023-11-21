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
    public $idMaterial;

    public function __construct($idBom, $idMaterial)
    {
        $this->idBom = $idBom;
        $this->idMaterial = $idMaterial;
    }

    public function build()
    {
        return $this->view('planner.bom.material-pending-notif')
            ->subject('Material Pending Notification')
            ->with('idBom', $this->idBom); // Kirim idMaterialBom ke tampilan email
    }
}