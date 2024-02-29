<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('attendance:masudrana')->everyFiveMinutes();

        // 10 AM.
        // $schedule->command('attendance:masudrana')->daily()
        // ->timezone('Asia/Dhaka')
        // ->at('10:00');
        // 1 PM.
        // $schedule->command('attendance:masudrana')->daily()
        // ->timezone('Asia/Dhaka')
        // ->at('13:00');
        // 5:30 PM.
        // $schedule->command('attendance:masudrana')->daily()
        // ->timezone('Asia/Dhaka')
        // ->at('17:30');

        // $schedule->command('attendance:masudrana')->daily()
        // ->timezone('Asia/Dhaka')
        // ->at('14:43');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
