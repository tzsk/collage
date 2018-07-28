<?php

namespace Tzsk\Collage\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class LaravelTestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Tzsk\Collage\Provider\CollageServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Collage' => 'Tzsk\Collage\Facade\Collage'
        ];
    }
}
