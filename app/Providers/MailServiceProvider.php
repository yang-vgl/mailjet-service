<?php

namespace App\Providers;

use App\Services\Base\MailjetV31Service;
use App\Services\Base\MailjetV3Service;
use Illuminate\Support\ServiceProvider;
use Mailjet\Client;
use App\Contracts\MailTransactionnalContract;
use App\Contracts\MailCommonContract;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register Mailjet connection.
     * API V3(common) for get request
     * API v3.1(transactional) for post request
     */
    public function register()
    {
        $this->app->bind(MailTransactionnalContract::class, function ($app) {
            $config = $this->app['config']->get('services.mailjet', array());
            $call = $this->app['config']->get('services.mailjet.transactional.call', true);
            $options = $this->app['config']->get('services.mailjet.transactional.options', array());
            return new MailjetV31Service($config['key'], $config['secret'], $call, $options);
        });

        $this->app->bind(MailCommonContract::class, function ($app) {
            $config = $this->app['config']->get('services.mailjet', array());
            $call = $this->app['config']->get('services.mailjet.common.call', true);
            $options = $this->app['config']->get('services.mailjet.common.options', array());
            return new MailjetV3Service($config['key'], $config['secret'], $call, $options);
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
