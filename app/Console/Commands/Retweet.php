<?php

namespace App\Console\Commands;

use App\Jobs\RetweetJob;
use Illuminate\Console\Command;

class Retweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'a commend to automatically retweet in twitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        RetweetJob::dispatch();

        // dispatch(new RetweetJob());
        return 0;
    }
}
