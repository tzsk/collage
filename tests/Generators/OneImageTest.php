<?php

namespace Tzsk\Collage\Tests\Generators;

use Intervention\Image\Image;
use Tzsk\Collage\Exceptions\ImageCountException;
use Tzsk\Collage\Generators\OneImage;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Tests\TestCase;

class OneImageTest extends TestCase
{
    protected $generator;

    protected $images = [
        'tests/images/image.jpg',
    ];

    public function setUp() : void
    {
        $this->generator = new OneImage($this->getFile(), new Config);
    }

    public function test_it_should_not_accept_more_number_of_files()
    {
        $this->images[] = 'tests/images/image.jpg';
        $generator = new OneImage($this->getFile(), new Config);
        $this->expectException(ImageCountException::class);
        $generator->create();
    }

    public function test_it_should_not_accept_less_number_of_files()
    {
        unset($this->images[0]);
        $generator = new OneImage($this->getFile(), new Config);
        $this->expectException(ImageCountException::class);
        $generator->create();
    }

    public function test_it_should_return_intervention_image()
    {
        $this->assertInstanceOf(Image::class, $this->generator->create());
    }

    public function test_it_should_have_just_create_method()
    {
        $this->assertTrue(method_exists($this->generator, 'create'));
    }

    public function getFile()
    {
        return (new File)->setWidth(100)->setHeight(100)->setFiles($this->images);
    }
}
