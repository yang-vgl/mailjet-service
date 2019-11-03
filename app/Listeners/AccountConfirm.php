<?php

namespace App\Listeners;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Services\AccountConfirmationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AccountConfirm implements ShouldQueue
{
    protected $service;

    /**
     * Create the event listener.
     * @param AccountConfirmationService $service
     */
    public function __construct(AccountConfirmationService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     * @param AccountCreate $event
     * @return void
     */
    public function handle(AccountCreate $event)
    {
        Log::info("email sent through event-listener");
        $res = $this->service->send($event->data);
        print_r($res);
    }
}
