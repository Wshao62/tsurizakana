<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

        Commands\TempDirectory::class,
        Commands\FishGarbage::class,
        Commands\EmailNotification::class,
        Commands\ChangeOrderIsAbleTransfer::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('temp:clean')->hourly();
        $schedule->command('fish:garbage')->dailyAt('18:00');
        $schedule->command('notify:mail')->hourly();
        $schedule->command('order:changeIsAbleTransfer')->weekly()->mondays()->at('00:00');
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
