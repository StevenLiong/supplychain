<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishGoodNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subjekEmail;
    public $kanbanfg;

    /**
     * Create a new notification instance.
     */
    public function __construct($subjekEmail, $kanbanfg)
    {
        $this->kanbanfg = $kanbanfg;
        $this->subjekEmail = $subjekEmail;
    }

    public function build()
    {
        return $this->view('planner.finishgood.fg-pending-notif')
            ->with([
                'subjekEmail' => $this->subjekEmail,
                'kanbanfg' => $this->kanbanfg,
            ]);
    }


}
