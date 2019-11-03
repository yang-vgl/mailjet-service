<?php

namespace App\Listeners;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Services\AccountConfirmationService;
use App\Services\WelcomeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use \App\Events\AccountConfirm as AccountConfirmEvent;

class Welcome
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
        print_r($res);exit;
    }
}
