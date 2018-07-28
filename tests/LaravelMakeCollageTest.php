<?php

namespace Tzsk\Collage\Tests;

use Intervention\Image\Image;
use Tzsk\Collage\MakeCollage;
use Tzsk\Collage\Facade\Collage;
use Intervention\Image\ImageManagerStatic;

class LaravelMakeCollageTest extends LaravelTestCase
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
            'tests/images/image.jpg'
        ];

        $this->assertInstanceOf(Image::class, Collage::make(100)->from($images));
    }
}
