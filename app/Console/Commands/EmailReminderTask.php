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
    protected $signature = 'run:email-reminder';
    protected $description = 'Manually run the email reminder task';

    public function handle()
    {
        $this->info('Running email reminder task...');

        $materials = Detailbom::where('last_kirim_email', '<=', now()->subDays(2))->get();

        foreach ($materials as $material) {
            $this->call('email:reminder', ['id' => $material->id_boms]);
            $this->info("Email reminder sent for material ID: {$material->id_boms}");
        }

        $this->info('Email reminder task completed.');
    }
}
