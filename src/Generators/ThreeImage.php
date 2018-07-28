<?php

namespace Tzsk\Collage\Generators;

use Closure;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Contracts\CollageGenerator;

class ThreeImage extends CollageGenerator
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
        $this->check(3);

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
     * One Image on Top, Two on Bottom.
     */
    public function twoTopOneBottom()
    {
        list($width, $height, $largeWidth) = $this->getWidthSize();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, $height), 'top-left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, $height), 'top-right');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($largeWidth, $height), 'bottom');
    }

    /**
     * Two Image on Top, One on Bottom.
     */
    public function oneTopTwoBottom()
    {
        list($width, $height, $largeWidth) = $this->getWidthSize();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($largeWidth, $height), 'top');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, $height), 'bottom-left');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, $height), 'bottom-right');
    }

    /**
     * Two Image on Left, One on Right.
     */
    public function twoLeftOneRight()
    {
        list($width, $height, $largeHeight) = $this->getHeightSize();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, $height), 'top-left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, $largeHeight), 'right');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, $height), 'bottom-left');
    }

    /**
     * One Image on Left, Two on Right.
     */
    public function oneLeftTwoRight()
    {
        list($width, $height, $largeHeight) = $this->getHeightSize();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, $largeHeight), 'left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, $height), 'top-right');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, $height), 'bottom-right');
    }

    /**
     * Align Image Horizontally.
     */
    public function horizontal()
    {
        $width = $this->file->getWidth() - $this->file->getPadding();
        $height = $this->file->getHeight() / 3 - $this->file->getPadding() * 0.75;

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit($width, ceil($height)), 'top');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit($width, ceil($height)), 'center');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit($width, ceil($height)), 'bottom');
    }

    /**
     * Align Image Vertically.
     */
    public function vertical()
    {
        $width = $this->file->getWidth() / 3 - $this->file->getPadding() * 0.75;
        $height = $this->file->getHeight() - $this->file->getPadding();

        $one = $this->images->get(0);
        $this->canvas->insert($one->fit(ceil($width), $height), 'left');

        $two = $this->images->get(1);
        $this->canvas->insert($two->fit(ceil($width), $height), 'center');

        $three = $this->images->get(2);
        $this->canvas->insert($three->fit(ceil($width), $height), 'right');
    }

    /**
     * @param Closure $closure
     */
    protected function makeSelection($closure = null)
    {
        if ($closure) {
            call_user_func($closure, $this);
        } else {
            $this->twoTopOneBottom();
        }
    }

    /**
     * @return array
     */
    protected function getWidthSize()
    {
        list($width, $height) = $this->getSmallSize();
        $largeWidth = $this->file->getWidth() - $this->file->getPadding();

        return [$width, $height, $largeWidth];
    }

    /**
     * @return array
     */
    protected function getHeightSize()
    {
        list($width, $height) = $this->getSmallSize();
        $largeHeight = $this->file->getHeight() - $this->file->getPadding();

        return [$width, $height, $largeHeight];
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
