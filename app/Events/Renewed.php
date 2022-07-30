<?php

namespace App\Events;

use App\Jobs\CallbackJob;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Renewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const TYPE = 'renewed';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($endpoint, $event)
    {
        CallbackJob::dispatch($endpoint, $event, self::TYPE);
    }

}
