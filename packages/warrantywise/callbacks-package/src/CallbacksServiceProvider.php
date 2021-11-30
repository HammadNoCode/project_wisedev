<?php

namespace Callbacks;

use Illuminate\Support\ServiceProvider;

use Callbacks\Http\Controllers\CallbacksController;

class CallbacksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadMigrationsFrom(__DIR__.'/Database/Migrations/Staff');
        $this->loadRoutesFrom(__DIR__ . '/StaffRoutes.php');
    }

    public function register()
    {
        $this->app->bind('CallbacksController', function($app){
            return new CallbacksController();
        });
    }
}