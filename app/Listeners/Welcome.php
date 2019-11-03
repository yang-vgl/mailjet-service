<?php

namespace App\Listeners;

use App\Services\Transactional\WelcomeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use \App\Events\AccountConfirm as AccountConfirmEvent;

class Welcome implements ShouldQueue
{
    protected $service;

    /**
     * @param WelcomeService $service
     */
    public function __construct(WelcomeService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param AccountConfirmEvent $event
     * @return void
     */
    public function handle(AccountConfirmEvent $event)
    {
        Log::info("email sent through event-listener");
        $res = $this->service->send($event->data);
        print_r($res);
    }
}
