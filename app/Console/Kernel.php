<?php

namespace App\Console;

use App\Http\Controllers\MailController;
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
        \App\Console\Commands\AddDateDailyTask::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('add_date_daily:task')->dailyAt('01:02');
        
        $schedule->call([new MailController, 'certificate'])->dailyAt('08:02');

        $schedule->call([new MailController, 'facility'])->dailyAt('08:07');

        $schedule->call([new MailController, 'finishproject'])->dailyAt('08:12');

        $schedule->call([new MailController, 'milestone'])->dailyAt('08:17');

        $schedule->call([new MailController, 'overtime'])->dailyAt('08:22');

        $schedule->call([new MailController, 'plan'])->weekly()->mondays()->at('08:27');

        $schedule->call([new MailController, 'pmorder'])->weekly()->mondays()->at('08:32');

        $schedule->call([new MailController, 'request_man'])->dailyAt('08:37');

        $schedule->call([new MailController, 'tool_calibrate'])->weekly()->mondays()->at('08:42');

        $schedule->call([new MailController, 'tool_pm'])->weekly()->mondays()->at('08:47');
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
