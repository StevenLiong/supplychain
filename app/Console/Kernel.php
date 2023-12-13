<?php

namespace App\Console;

use EmailCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        Commands\EmailCommand::class;
        // $this->command('email:reminder', [EmailCommand::class]);

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:reminder')->daily(); // Sesuaikan dengan kebutuhan jadwal Anda
    }
}
