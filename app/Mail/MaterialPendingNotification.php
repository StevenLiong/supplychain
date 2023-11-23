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
    public $notifMaterial;

    public function __construct($notifMaterial, $subject, $id_bom)
    {
        $this->notifMaterial = $notifMaterial;
        $this->subject = $subject;
        $this->idBom = $id_bom;
    }
    public function build()
    {
        return $this->view('planner.bom.material-pending-notif')
            ->with('idBom', $this->idBom); // Kirim idMaterialBom ke tampilan email
    }
}