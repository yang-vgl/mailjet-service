<?php

namespace App\Listeners;

use App\Events\AccountCreate;
use App\Events\ForgetPassword;
use App\Events\PriceChange;
use App\Services\TransactionalEmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class EmailEventSubscriber implements ShouldQueue
{
    protected $transactional_service;

    /**
     * Create the event listener.
     * @param TransactionalEmailService $transactional_service
     */
    public function __construct(TransactionalEmailService $transactional_service)
    {
        $this->transactional_service = $transactional_service;
    }

    /**
     * Handle user login events.
     *
     * @param $event
     */
    public function handleAccountCreate($event)
    {
        Log::info("email sent through event-listener");
        $res = $this->transactional_service->sendAccountConfirmation($event->data);
        print_r($res);
    }

    /**
     * Handle user logout events.
     *
     * @param $event
     */
    public function handleAccountConfirm($event)
    {
        Log::info("email sent through event-listener");
        $res = $this->transactional_service->sendWelcome($event->data);
        print_r($res);
    }

    /**
     * Handle user logout events.
     *
     * @param $event
     */
    public function handleForgetPassword($event)
    {
        Log::info("reset password email sent through event-listener");
        $res = $this->transactional_service->sendResetPassword($event->data);
        print_r($res);
    }

    /**
     * Handle user logout events.
     *
     * @param $event
     */
    public function handlePriceChange($event)
    {
        Log::info("price alert email sent through event-listener");
        $res = $this->transactional_service->sendPriceAlert($event->data);
        print_r($res);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            AccountCreate::class,
            'App\Listeners\EmailEventSubscriber@handleAccountCreate'
        );

        $events->listen(
            \App\Events\AccountConfirm::class,
            'App\Listeners\EmailEventSubscriber@handleAccountConfirm'
        );

        $events->listen(
            ForgetPassword::class,
            'App\Listeners\EmailEventSubscriber@handleForgetPassword'
        );

        $events->listen(
            PriceChange::class,
            'App\Listeners\EmailEventSubscriber@handlePriceChange'
        );
    }
}
