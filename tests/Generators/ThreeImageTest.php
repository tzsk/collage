<?php

namespace Tzsk\Collage\Tests\Generators;

use Intervention\Image\Image;
use Tzsk\Collage\Exceptions\ImageCountException;
use Tzsk\Collage\Generators\ThreeImage;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Tests\TestCase;

class ThreeImageTest extends TestCase
{
    protected $generator;

    protected $images = [
        'tests/images/image.jpg',
        'tests/images/image.jpg',
        'tests/images/image.jpg',
    ];

    public function setUp() : void
    {
        $this->generator = new ThreeImage($this->getFile(), new Config);
    }

    public function test_it_should_not_accept_more_number_of_files()
    {
        $this->images[] = 'tests/images/image.jpg';
        $generator = new ThreeImage($this->getFile(), new Config);
        $this->expectException(ImageCountException::class);
        $generator->create();
    }

    public function test_it_should_not_accept_less_number_of_files()
    {
        unset($this->images[2]);
        $generator = new ThreeImage($this->getFile(), new Config);
        $this->expectException(ImageCountException::class);
        $generator->create();
    }

    public function test_it_should_return_intervention_image()
    {
        $this->assertInstanceOf(Image::class, $this->generator->create());
    }

    public function test_it_should_have_a_create_method()
    {
        $this->assertTrue(method_exists($this->generator, 'create'));
    }

    public function test_it_should_have_vertical_method()
    {
        $this->assertTrue(method_exists($this->generator, 'vertical'));
    }

    public function test_it_should_have_horizontal_method()
    {
        $this->assertTrue(method_exists($this->generator, 'horizontal'));
    }

    public function test_it_should_have_twoTopOneBottom_method()
    {
        $this->assertTrue(method_exists($this->generator, 'twoTopOneBottom'));
    }

    public function test_it_should_have_oneTopTwoBottom_method()
    {
        $this->assertTrue(method_exists($this->generator, 'oneTopTwoBottom'));
    }

    public function test_it_should_have_twoLeftOneRight_method()
    {
        $this->assertTrue(method_exists($this->generator, 'twoLeftOneRight'));
    }

    public function test_it_should_have_oneLeftTwoRight_method()
    {
        $this->assertTrue(method_exists($this->generator, 'oneLeftTwoRight'));
    }

    public function getFile()
    {
        return (new File)->setWidth(100)->setHeight(100)->setFiles($this->images);
    }
}
