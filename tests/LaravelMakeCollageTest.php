<?php

namespace Tzsk\Collage\Tests;

use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Contracts\CollageGenerator;
use Tzsk\Collage\Facade\Collage;
use Tzsk\Collage\MakeCollage;

class LaravelMakeCollageTest extends TestCase
{
    public function test_it_uses_make_collage_class()
    {
        $this->assertInstanceOf(MakeCollage::class, Collage::make(100));
    }

    public function test_it_does_all_the_usual_things()
    {
        $images = [
            ImageManagerStatic::make('tests/images/image.jpg'),
            file_get_contents('tests/images/image.jpg'),
            'tests/images/image.jpg',
        ];

        $this->assertInstanceOf(Image::class, Collage::make(100)->from($images));
    }

    public function test_it_can_be_extended_from_config()
    {
        config(['collage.generators.5' => FakeCollageGenerator::class]);
        $images = [
            'tests/images/image.jpg',
            'tests/images/image.jpg',
            'tests/images/image.jpg',
            'tests/images/image.jpg',
            'tests/images/image.jpg',
        ];
        $collage = Collage::make(400)->from($images);
        $this->assertInstanceOf(Image::class, $collage);
    }
}

class FakeCollageGenerator extends CollageGenerator
{
    public function create($closure = null)
    {
        return ImageManagerStatic::make('tests/images/image.jpg');
    }

    public function getImages()
    {
        return $this->images;
    }

    public function fakeCheck($count)
    {
        $this->check($count);
    }
}
