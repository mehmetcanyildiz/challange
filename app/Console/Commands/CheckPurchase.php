<?php

namespace App\Console\Commands;

use App\Enum\MessagesEnum;
use App\Models\Purchase;
use App\Jobs\Purchase as PurchaseJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckPurchase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purchase Check Subscription';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $purchases = Purchase::where('status', '=', 1)
            ->whereDate('expire_time', '<=', date('Y-m-d', strtotime('+1 month')))
            ->get();
        foreach ($purchases as $purchase) {
            Log::info(sprintf(MessagesEnum::PURCHASE_ADDED_JOB, $purchase->id));
            PurchaseJob::dispatch($purchase);
        }
    }
}
