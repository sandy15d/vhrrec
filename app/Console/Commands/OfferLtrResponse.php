<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OfferLtrResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Reject Offer Letter after 7 days';

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
        \Log::info('OfferLtrResponse: Auto Reject Offer Letter after 7 days');
    }
}
