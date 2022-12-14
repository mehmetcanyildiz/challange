<?php

namespace App\Events;

use App\Jobs\Callback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Started
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const TYPE = 'started';

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
