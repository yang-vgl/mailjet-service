<?php

namespace App\Providers;

use App\Services\Base\MailjetV31Service;
use App\Services\Base\MailjetV3Service;
use Illuminate\Support\ServiceProvider;
use App\Contracts\MailTransactionalContract;
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
        $this->app->bind(MailTransactionalContract::class, function ($app) {
            $config = $app['config']->get('services.mailjet', array());
            $call = $app['config']->get('services.mailjet.transactional.call', true);
            $options = $app['config']->get('services.mailjet.transactional.options', array());
            return new MailjetV31Service($config['key'], $config['secret'], $call, $options);
        });

        $this->app->bind(MailCommonContract::class, function ($app) {
            $config = $app['config']->get('services.mailjet', array());
            $call = $app['config']->get('services.mailjet.common.call', true);
            $options = $app['config']->get('services.mailjet.common.options', array());
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
