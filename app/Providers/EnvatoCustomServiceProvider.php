<?php

namespace App\Providers;

use App\Library\Services\DemoOne;
use Illuminate\Support\ServiceProvider;

class EnvatoCustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\DemoOne', function ($app) {
            return new DemoOne();
          });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
