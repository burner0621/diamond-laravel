<?php

namespace App\Console\Commands;

use App\Models\CurrentRate;
use Illuminate\Console\Command;

class GetCurrentRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:get_current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Current Rate';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CurrentRate::getCurrentRate();

        return 0;
    }
}
