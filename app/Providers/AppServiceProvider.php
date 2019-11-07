<?php

namespace App\Providers;

use App\Contracts\LogContract;
use App\Services\Log\PiwikService;
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
            $tracker =  new PiwikTrackerService(1);
            $tracker::$URL = 'https://asia-cloud-test-48-duyang.matomo.cloud/matomo.php';
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
