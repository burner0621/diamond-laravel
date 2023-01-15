<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckPendingBalance;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckPendingBalance::class
    ];    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --queue=high,default')->everyTwoMinutes();
        $schedule->command('check:pendingbalance')->timezone('America/New_York')->dailyAt('00:00')->runInBackground();
        $schedule->command('rate:get_current')->timezone('America/New_York')->dailyAt('09:00')->runInBackground();
        // $schedule->command('queue:listen --queue=high,default')->everyTwoMinutes();
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
