<?php
namespace Tzsk\Collage\Contracts;

use Closure;
use Illuminate\Support\Collection;
use Intervention\Image\ImageManagerStatic as Image;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Helpers\File;

abstract class CollageGenerator
{
	/**
	 * @var File
	 */
	protected $file;

	/**
	 * @var Collection
	 */
	protected $images;

    /**
     * CollageGenerator constructor.
     *
     * @param File $file
     * @param Config $config
     */
	public function __construct( File $file, Config $config )
	{
		$this->file = $file;
        Image::configure(['driver' => $config->getDriver()]);
		$this->transformFiles();
	}

	/**
	 * @param Closure $closure
	 *
	 * @return Image
	 */
	public function create($closure = null)
	{
		//
	}

	/**
	 * Set file transformations.
	 */
	protected function transformFiles()
	{
		$images = collect();
		foreach ( $this->file->getFiles() as $file ) {
			if ($file instanceof Image) {
				$images->push($file);
			} else {
				$images->push(Image::make($file));
			}
		}

		$this->images = $images;
	}
}