<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VonageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Vonage\Client::class, function ($app) {
            $basic  = new \Vonage\Client\Credentials\Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
            return new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic));
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
