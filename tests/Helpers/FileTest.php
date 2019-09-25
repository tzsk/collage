<?php

namespace Tzsk\Collage\Tests\Helpers;

use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Tests\PhpTestCase;

class FileTest extends PhpTestCase
{
    /**
     * @var File
     */
    protected $file;

    public function setUp() : void
    {
        $this->file = new File;
    }

    public function test_it_should_have_width()
    {
        $this->assertEmpty($this->file->getWidth());

        $this->assertEquals(100, $this->file->setWidth(100)->getWidth());
    }

    public function test_it_should_have_height()
    {
        $this->assertEmpty($this->file->getHeight());

        $this->assertEquals(100, $this->file->setHeight(100)->getHeight());
    }

    public function test_it_should_have_padding()
    {
        $this->assertEmpty($this->file->getPadding());

        $this->assertEquals(10, $this->file->setPadding(10)->getPadding());
    }

    public function test_it_should_have_color()
    {
        $this->assertEmpty($this->file->getColor());

        $this->assertEquals('foo', $this->file->setColor('foo')->getColor());
    }

    public function test_it_should_have_files()
    {
        $this->assertCount(0, $this->file->getFiles());

        $file = $this->file->setFiles(['foo']);

        $this->assertCount(1, $file->getFiles());
    }
}
