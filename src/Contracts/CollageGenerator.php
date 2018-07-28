<?php

namespace Tzsk\Collage\Contracts;

use Closure;
use Tzsk\Collage\Helpers\File;
use Tzsk\Collage\Helpers\Config;
use Illuminate\Support\Collection;
use Tzsk\Collage\Exceptions\ImageCountException;
use Intervention\Image\ImageManagerStatic as Image;

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
    public function __construct(File $file, Config $config)
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
    abstract public function create($closure = null);

    /**
     * Set file transformations.
     */
    protected function transformFiles()
    {
        $images = collect();
        foreach ($this->file->getFiles() as $file) {
            if ($file instanceof Image) {
                $images->push($file);
            } else {
                $images->push(Image::make($file));
            }
        }

        $this->images = $images;
    }

    /**
     * @param integer $count
     * @throws ImageCountException
     * @return void
     */
    protected function check($count)
    {
        $files = $this->images->count();
        if ($files != $count) {
            $message = "Cannot create collage of {$count} image with {$files} image(s)";
            throw new ImageCountException($message);
        }
    }
}
