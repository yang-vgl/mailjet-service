<?php

namespace App\Listeners;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Services\AccountConfirmationService;
use App\Services\ResetPasswordService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\ForgetPassword;

class ResetPassword
{
    protected $service;

    /**
     * Create the event listener.
     * @param ResetPasswordService $service
     */
    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ForgetPassword $event)
    {
        Log::info("reset password email sent through event-listener");
        //$this->trans->testSend($this->mjV31);
        $res = $this->service->send($event->data);
        print_r($res);exit;
    }
}
