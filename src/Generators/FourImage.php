<?php
namespace Tzsk\Collage\Generators;

use Closure;
use Intervention\Image\ImageManagerStatic as Image;
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
	 * @return \Intervention\Image\Image|\Intervention\Image\ImageManagerStatic
	 */
	public function create( $closure = null )
	{
		$height = $this->file->getHeight() - $this->file->getPadding();
		$width = $this->file->getWidth() - $this->file->getPadding();

		$this->canvas = Image::canvas($width, $height);

		$this->process();

		return Image::canvas($this->file->getWidth(), $this->file->getHeight(), $this->file->getColor())
		            ->insert($this->canvas, 'center');
	}

	/**
	 * Process all images.
	 */
	protected function process()
	{
		list( $width, $height ) = $this->getSmallSize();

		$one = $this->images->get(0);
		$this->canvas->insert($one->fit($width, $height), 'top-left');

		$two = $this->images->get(1);
		$this->canvas->insert($two->fit($width, $height), 'top-right');

		$three = $this->images->get(2);
		$this->canvas->insert($three->fit($width, $height), 'bottom-left');

		$three = $this->images->get(3);
		$this->canvas->insert($three->fit($width, $height), 'bottom-right');
	}

	/**
	 * @return array
	 */
	protected function getSmallSize()
	{
		$width  = $this->file->getWidth() / 2 - ceil( $this->file->getPadding() * 0.75 );
		$height = $this->file->getHeight() / 2 - ceil( $this->file->getPadding() * 0.75 );

		return [$width, $height];
	}
}