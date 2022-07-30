<?php

namespace App\Jobs;

use App\Enum\MessagesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $url;
    public string $endpoint;
    public string $type;
    public array $event;
    public int $tries = 3;
    public int $timeOut = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($endpoint, $event, $type)
    {
        $this->endpoint = $endpoint;
        $this->event = $event;
        $this->type = $type;
        $this->url = sprintf('%s?type=%s', $this->endpoint, $this->type);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $client = new Client();
        $response = $client->post($this->url, [
            'form_params' => $this->event,
            'timeout' => $this->timeOut,
            'connect_timeout' => $this->timeOut,
        ]);
        if ($response->getStatusCode() == '200') {
            Log::info(MessagesEnum::CALLBACK_SUCCESS);
        } else {
            $this->release(3600);
            Log::info(MessagesEnum::CALLBACK_FAILED);
        }
    }
}
