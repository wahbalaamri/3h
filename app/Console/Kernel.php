<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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

        // $schedule->command('inspire')->hourly();
        $schedule->command("testcommand:log")->when(function () {
            //get date and time now
            $now = date("Y-m-d H:i:s");

            return ($now >= '2023-08-25 21:55:00' && $now <= '2023-08-25 22:10:00');
        })->cron('*/15 * * * *');
        $schedule->command("DailyReminder:Reminder")->when(function () {
            //get date now
            $now = date("Y-m-d");
            //get time now
            $time = date("H:i:s");
           // Log::alert($time);
            return $now > '2023-08-25' && ($time>='04:00:00' && $time<='04:15:00');

        })->cron('*/15 * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
