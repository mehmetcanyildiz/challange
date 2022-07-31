<?php

namespace App\Jobs;

use App\Enum\MessagesEnum;
use App\Enum\PurchaseStatusEnum;
use App\Events\Canceled;
use App\Events\Renewed;
use App\Events\Started;
use Illuminate\Bus\Queueable;
use App\Models\Purchase as PurchaseModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Purchase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public PurchaseModel $data;
    public int $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        self::onQueue('check-purchase');
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (PurchaseModel::rateLimit($this->data->receipt)) {
            Log::info(sprintf('%s %s', $this->data->id, MessagesEnum::PURCHASE_RATE_LIMIT));
            $this->release(3600);
        } else {
            $event = [$this->data->device->app_id, $this->data->device->uid];
            $endpoint = $this->data->device->app->callback;

            $verify = PurchaseModel::verify($this->data->device->os, $this->data->receipt);
            if (!$verify['status']) {
                event(new Canceled($endpoint, $event));
                Log::info(sprintf('%s %s', $this->data->id, MessagesEnum::PURCHASE_SUB_CANCELED));
            }
            PurchaseModel::where([
                'id' => $this->data->id
            ])->update([
                'expire_time' => $verify['expire_time'],
                'status' => PurchaseStatusEnum::PURCHASE_STATUS_ACTIVE
            ]);
            $purchase = PurchaseModel::find($this->data->id);
            if ($purchase->created_at == $purchase->updated_at) {
                Log::info(sprintf('%s %s', $this->data->id, MessagesEnum::PURCHASE_SUB_STARTED));
                event(new Started($endpoint, $event));
            } else {
                Log::info(sprintf('%s %s', $this->data->id, MessagesEnum::PURCHASE_SUB_RENEWED));
                event(new Renewed($endpoint, $event));
            }
            event(new Started($endpoint, $event));
        }
    }
}
