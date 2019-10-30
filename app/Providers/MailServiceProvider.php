<?php

namespace App\Providers;

use App\Services\MailjetV31Service;
use Illuminate\Support\ServiceProvider;
use Mailjet\Client;
use App\Contracts\MailTransactionnalContract;
use App\Contracts\MailCommonContract;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     */
    public function register()
    {
        $this->app->bind(MailTransactionnalContract::class, function ($app) {
            $config = $this->app['config']->get('services.mailjet', array());
            $call = $this->app['config']->get('services.mailjet.transactional.call', true);
            $options = $this->app['config']->get('services.mailjet.transactional.options', array());
            return new MailjetV31Service($config['key'], $config['secret'], $call, $options);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }


}
