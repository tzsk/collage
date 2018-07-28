<?php

namespace Tzsk\Collage\Tests;

use Intervention\Image\Image;
use Tzsk\Collage\MakeCollage;
use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Helpers\Config;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Contracts\CollageGenerator;

class MakeCollageTest extends PhpTestCase
{
    /**
     * @var MakeCollage
     */
    protected $collage;

    public function setUp()
    {
        $this->collage = new FakeMakeCollage;
    }

    public function test_it_should_have_width_and_height()
    {
        $collage = $this->collage->make(100);
        $this->assertEquals(100, $collage->getFile()->getWidth());
        $this->assertEquals(100, $collage->getFile()->getHeight());

        $collage = $this->collage->make(200, 300);
        $this->assertEquals(200, $collage->getFile()->getWidth());
        $this->assertEquals(300, $collage->getFile()->getHeight());
    }

    public function test_it_should_have_padding()
    {
        $this->assertEquals(0, $this->collage->getFile()->getPadding());

        $collage = $this->collage->padding(20);
        $this->assertEquals(20, $this->collage->getFile()->getPadding());
    }

    public function test_it_should_have_a_background()
    {
        $this->assertEmpty($this->collage->getFile()->getColor());

        $collage = $this->collage->background('foo');
        $this->assertEquals('foo', $this->collage->getFile()->getColor());
    }

    public function test_it_should_have_file_count()
    {
        $collage = $this->collage->setFiles(['foo']);

        $this->assertCount(1, $collage->getFile()->getFiles());
    }

    public function test_it_should_return_collage_generator()
    {
        $class = $this->collage->getConfig()->getGenerator(1);

        $this->assertEquals(CollageGenerator::class, get_parent_class($class));
    }

    public function test_it_should_return_intervention_image()
    {
        $image = $this->collage->make(100)->from(['tests/images/image.jpg']);

        $this->assertInstanceOf(Image::class, $image);
    }

    public function test_it_accepts_all_kinds_of_targets()
    {
        $images = [
            ImageManagerStatic::make('tests/images/image.jpg'),
            'https://tzsk.github.io/img/portfolio/thumbnails/2.jpg',
            file_get_contents('tests/images/image.jpg'),
            'tests/images/image.jpg'
        ];

        $this->assertInstanceOf(Image::class, $this->collage->make(100)->from($images));
    }
}

class FakeMakeCollage extends MakeCollage
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $files
     * @return MakeCollage
     */
    public function setFiles(array $files)
    {
        $this->file->setFiles($files);

        return $this;
    }
}
