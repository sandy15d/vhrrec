<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OfferLtr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offerletter:reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Offer Letter Auto Reject after 7 days';

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
        \Log::info("Cron is working Fine!");
    }
}
