<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Socialite;
use Laravel\Socialite\Two\PolarProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->bootPolarSocialite();
    }

    private function bootPolarSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'polar',
            function ($app) use ($socialite) {
                $config = $app['config']['services.polar'];
                return $socialite->buildProvider(PolarProvider::class, $config);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
