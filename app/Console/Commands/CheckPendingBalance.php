<?php

namespace App\Console\Commands;

use App\Models\SellersProfile;
use App\Models\SellersWalletHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPendingBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pendingbalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check sellers pending balance and delete if its already past 14 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingBalances = SellersWalletHistory::where('type', 'add')->where('status', 0)->get();
        foreach ($pendingBalances as $pending) {
            if (Carbon::now()->diffInDays($pending->updated_at->startOfDay()) == 14) {
                $wallet = SellersProfile::where('user_id', $pending->user_id)->first();
                if ($wallet) {
                    // $wallet->wallet += $pending->amount;
                    // $wallet->save();
                    $pending->status = 1;
                    $pending->save();
                }
            }
        }
        $this->info("Success");
        return Command::SUCCESS;
    }
}
