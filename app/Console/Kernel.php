<?php

namespace App\Console;

use App\Jobs\PostAboutViralocal;
use App\Jobs\RetweetJob;
use App\Jobs\TweetAboutWebsite;
use App\Models\Post;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('app:retweet')->everyMinute();
        // $schedule->job(new RetweetJob)->everyThirtyMinutes();
        // $schedule->job(new TweetAboutWebsite)->hourly();
        // $schedule->job(new PostAboutViralocal)->everyTwoHours();
        // $schedule->call(function() {
        //     Post::query()
        //                 ->where('created_at', '<', today()->subDays(30) )
        //                 ->update(['status' => 'deleted']);
        // })->daily();
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
