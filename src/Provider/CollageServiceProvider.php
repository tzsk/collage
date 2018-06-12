<?php

namespace Tzsk\Collage\Provider;

use Tzsk\Collage\MakeCollage;
use Illuminate\Support\ServiceProvider;

class CollageServiceProvider extends ServiceProvider
{
    /**
     * Perform booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Publish Config File.
         */
        $this->publishes([
            __DIR__.'/../Config/collage.php' => config_path('collage.php')
        ], 'config');

        /**
         * Register singleton.
         */
        $this->app->singleton('tzsk-collage', function ($app) {
            return $app->make(MakeCollage::class);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // merge default config
        $this->mergeConfigFrom(
            __DIR__.'/../Config/collage.php',
            'collage'
        );
    }
}
