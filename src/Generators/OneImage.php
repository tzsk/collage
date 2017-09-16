<?php
namespace Tzsk\Collage\Generators;

use Closure;
use Intervention\Image\ImageManagerStatic as Image;
use Tzsk\Collage\Contracts\CollageGenerator;

class OneImage extends CollageGenerator
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
	public function create( $closure = null )
	{
		$this->createCanvas();
		$this->process();
		return $this->canvas->insert($this->images->first(), 'center');
	}

    /**
     * Create the Outer canvas.
     */
    protected function createCanvas()
    {
        $width = $this->file->getWidth();
        $height = $this->file->getHeight();
        $color = $this->file->getColor();

        $this->canvas = Image::canvas($width, $height, $color);
	}

	/**
	 * Process Image.
	 */
	protected function process()
	{
		$width = $this->file->getWidth() - $this->file->getPadding();
		$height = $this->file->getHeight() - $this->file->getPadding();

		$this->images = collect([$this->images->first()->fit($width, $height)]);
	}

}