<?php

namespace App\Events;

use App\Jobs\Callback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Canceled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const TYPE = 'canceled';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($endpoint, $event)
    {
        Callback::dispatch($endpoint, $event, self::TYPE);
    }

}
