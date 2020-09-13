<?php

namespace Tzsk\Collage\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tzsk\Collage\Provider\CollageServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            CollageServiceProvider::class,
        ];
    }
}
