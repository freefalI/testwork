<?php

namespace App\Services\LogService;

use App\Services\LogService\DatabaseLogger;
use App\Services\LogService\Logger;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Logger::class,
            DatabaseLogger::class
        );
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
