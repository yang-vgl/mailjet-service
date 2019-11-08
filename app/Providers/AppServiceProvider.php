<?php

namespace App\Providers;

use App\Contracts\LogContract;
use App\Services\Log\PiwikTrackerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LogContract::class, function ($app) {
            $tracker =  new PiwikTrackerService( $app['config']->get('services.piwik.idSite'));
            $tracker::$URL = $app['config']->get('services.piwik.url');
            return $tracker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
