<?php

namespace TecBeast\FrontendRights;

use Illuminate\Support\ServiceProvider;

class FrontendRightsServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/frontend-rights.php' => config_path('frontend-rights.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
