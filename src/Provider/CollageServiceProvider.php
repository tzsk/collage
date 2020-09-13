<?php

namespace Tzsk\Collage\Provider;

use Illuminate\Support\ServiceProvider;
use Tzsk\Collage\Commands\PublishCollageConfig;
use Tzsk\Collage\MakeCollage;

class CollageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/collage.php' => config_path('collage.php'),
            ], 'collage-config');
        }

        $this->app->bind('tzsk-collage', function () {
            return (new MakeCollage(config('collage.driver')))
                ->with(config('collage.generators', []));
        });

        $this->commands([
            PublishCollageConfig::class,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/collage.php', 'collage');
    }
}
