<?php
namespace Tzsk\Collage\Generators;

use Closure;
use Intervention\Image\ImageManagerStatic as Image;
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
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManagerStatic
     */
    public function create($closure = null)
    {
        $height = $this->file->getHeight() - $this->file->getPadding();
        $width = $this->file->getWidth() - $this->file->getPadding();

        $this->canvas = Image::canvas($width, $height);

        $this->makeSelection($closure);

        return Image::canvas($this->file->getWidth(), $this->file->getHeight(), $this->file->getColor())
                    ->insert($this->canvas, 'center');
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
    public function oneTopTowBottom()
    {
        list($width, $height, $largeWidth) = $this->getWidthSize();

        $three = $this->images->get(0);
        $this->canvas->insert($three->fit($largeWidth, $height), 'top');

        $one = $this->images->get(1);
        $this->canvas->insert($one->fit($width, $height), 'bottom-left');

        $two = $this->images->get(2);
        $this->canvas->insert($two->fit($width, $height), 'bottom-right');
    }

    /**
     * Two Image on Left, One on Right.
     */
    public function twoLeftOneRight()
    {
        list($width, $height, $largeHeight) = $this->getHeightSize();

        $three = $this->images->get(0);
        $this->canvas->insert($three->fit($width, $height), 'top-left');

        $one = $this->images->get(1);
        $this->canvas->insert($one->fit($width, $largeHeight), 'right');

        $two = $this->images->get(2);
        $this->canvas->insert($two->fit($width, $height), 'bottom-left');
    }

    /**
     * One Image on Left, Two on Right.
     */
    public function oneLeftTwoRight()
    {
        list($width, $height, $largeHeight) = $this->getHeightSize();

        $three = $this->images->get(0);
        $this->canvas->insert($three->fit($width, $largeHeight), 'left');

        $one = $this->images->get(1);
        $this->canvas->insert($one->fit($width, $height), 'top-right');

        $two = $this->images->get(2);
        $this->canvas->insert($two->fit($width, $height), 'bottom-right');
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
        $width  = $this->file->getWidth() / 2 - ceil($this->file->getPadding() * 0.75);
        $height = $this->file->getHeight() / 2 - ceil($this->file->getPadding() * 0.75);

        return [$width, $height];
    }
}
