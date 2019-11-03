<?php

namespace App\Listeners;

use App\Events\PriceChange;
use App\Services\Transactional\PriceAlertService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class PriceAlert implements ShouldQueue
{
    protected $service;

    /**
     * Create the event listener.
     * @param PriceAlertService $service
     */
    public function __construct(PriceAlertService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param PriceChange $event
     * @return void
     */
    public function handle(PriceChange $event)
    {
        Log::info("price alert email sent through event-listener");
        $res = $this->service->send($event->data);
        print_r($res);
    }
}
