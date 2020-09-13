<?php

namespace Tzsk\Collage\Generators;

use Closure;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Contracts\CollageGenerator;

class FourImage extends CollageGenerator
{
    /**
     * @var Image
     */
    protected $canvas;

    /**
     * @param Closure $closure
     *
     * @return \Intervention\Image\Image
     */
    public function create($closure = null)
    {
        $this->check(4);

        $height = $this->file->getHeight() - $this->file->getPadding();
        $width = $this->file->getWidth() - $this->file->getPadding();

        $this->canvas = ImageManagerStatic::canvas($width, $height);

        $this->makeSelection($closure);

        return ImageManagerStatic::canvas(
            $this->file->getWidth(),
            $this->file->getHeight(),
            $this->file->getColor()
        )->insert($this->canvas, 'center');
    }

    /**
     * Align Image Horizontally.
     */
    public function horizontal()
    {
        $width = $this->file->getWidth() - $this->file->getPadding();
        $height = $this->file->getHeight() / 4 - $this->file->getPadding() * 0.75;

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, floor($height)), 'top');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, floor($height)), 'top', 0, intval($this->file->getHeight() / 4));

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, floor($height)), 'top', 0, intval($this->file->getHeight() / 2));

        $four = $this->images->get(3);
        $this->canvas->insert($four->fit($width, floor($height)), 'bottom');
    }

    /**
     * Align Image Vertically.
     */
    public function vertical()
    {
        $width = $this->file->getWidth() / 4 - $this->file->getPadding() * 0.75;
        $height = $this->file->getHeight() - $this->file->getPadding();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit(floor($width), $height), 'left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit(floor($width), $height), 'left', intval($this->file->getWidth() / 4));

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit(floor($width), $height), 'left', intval($this->file->getWidth() / 2));

        $four = $this->images->get(3);
        $this->canvas->insert($four->fit(floor($width), $height), 'right');
    }

    /**
     * Process all images.
     */
    public function grid()
    {
        list($width, $height) = $this->getSmallSize();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, $height), 'top-left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, $height), 'top-right');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, $height), 'bottom-left');

        $four = $this->images->get(3);
        $this->canvas->insert($four->fit($width, $height), 'bottom-right');
    }

    /**
     * @param Closure $closure
     */
    protected function makeSelection($closure = null)
    {
        if ($closure) {
            call_user_func($closure, $this);
        } else {
            $this->grid();
        }
    }

    /**
     * @return array
     */
    protected function getSmallSize()
    {
        $width = $this->file->getWidth() / 2 - ceil($this->file->getPadding() * 0.75);
        $height = $this->file->getHeight() / 2 - ceil($this->file->getPadding() * 0.75);

        return [$width, $height];
    }
}
