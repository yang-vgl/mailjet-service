<?php

namespace App\Listeners;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Events\PriceChange;
use App\Services\AccountConfirmationService;
use App\Services\PriceAlertService;
use App\Services\ResetPasswordService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\ForgetPassword;

class PriceAlert
{
    protected $service;

    /**s
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
        //$this->trans->testSend($this->mjV31);
        $res = $this->service->send($event->data);
        print_r($res);exit;
    }
}
