<?php

namespace App\Listeners;

use App\Services\Transactional\ResetPasswordService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Events\ForgetPassword;

class ResetPassword implements ShouldQueue
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
     * @param ForgetPassword $event
     * @return void
     */
    public function handle(ForgetPassword $event)
    {
        Log::info("reset password email sent through event-listener");
        $res = $this->service->send($event->data);
        print_r($res);
    }
}
