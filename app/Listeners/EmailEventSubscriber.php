<?php

namespace App\Listeners;

use App\Events\AccountCreate;
use App\Events\ForgetPassword;
use App\Events\PriceChange;
use App\Services\Transactional\AccountConfirmationService;
use App\Services\Transactional\PriceAlertService;
use App\Services\Transactional\ResetPasswordService;
use App\Services\Transactional\WelcomeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class EmailEventSubscriber implements ShouldQueue
{
    protected $account_confirmation_service;
    protected $welcome_service;
    protected $reset_password_service;
    protected $price_alert_service;

    /**
     * Create the event listener.
     *
     * @param AccountConfirmationService $account_confirmation_service
     * @param WelcomeService             $welcome_service
     * @param ResetPasswordService       $reset_password_service
     * @param PriceAlertService          $price_alert_service
     */
    public function __construct(
        AccountConfirmationService $account_confirmation_service,
        WelcomeService $welcome_service,
        ResetPasswordService $reset_password_service,
        PriceAlertService $price_alert_service
    ) {
        $this->account_confirmation_service = $account_confirmation_service;
        $this->welcome_service = $welcome_service;
        $this->reset_password_service = $reset_password_service;
        $this->price_alert_service = $price_alert_service;
    }

    /**
     * Handle user login events.
     *
     * @param $event
     */
    public function handleAccountCreate($event)
    {
        Log::info("email sent through event-listener");
        $res = $this->account_confirmation_service->send($event->data);
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
        $res = $this->welcome_service->send($event->data);
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
        $res = $this->reset_password_service->send($event->data);
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
        $res = $this->price_alert_service->send($event->data);
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
