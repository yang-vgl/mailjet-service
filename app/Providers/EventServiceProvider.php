<?php

namespace App\Providers;

use App\Events\AccountCreate;
use App\Events\ForgetPassword;
use App\Events\PriceChange;
use App\Listeners\AccountConfirm;
use App\Listeners\EmailEventSubscriber;
use App\Listeners\PriceAlert;
use App\Listeners\ResetPassword;
use App\Listeners\Welcome;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
//        AccountCreate::class => [
//            AccountConfirm::class
//        ],
//        \App\Events\AccountConfirm::class => [
//            Welcome::class
//        ],
//        ForgetPassword::class => [
//            ResetPassword::class
//        ],
//        PriceChange::class => [
//            PriceAlert::class
//        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        EmailEventSubscriber::class,
    ];

}
