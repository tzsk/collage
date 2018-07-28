<?php

namespace Tzsk\Collage\Tests\Contracts;

use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Tests\TestCase;
use Tzsk\Collage\Contracts\CollageGenerator;

class CollageGeneratorTest extends TestCase
{
    public function test_it_can_create_something()
    {
        $generator = new FakeCollageGenerator(new File, new Config);
        $this->assertEquals($generator->create(), 'foo');
    }
}

class FakeCollageGenerator extends CollageGenerator
{
    public function create($closure = null)
    {
        return 'foo';
    }
}
