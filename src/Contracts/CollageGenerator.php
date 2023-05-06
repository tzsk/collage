<?php

namespace Tzsk\Collage\Contracts;

use Closure;
use Illuminate\Support\Collection;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Tzsk\Collage\Exceptions\ImageCountException;
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
     */
    public function __construct(File $file, Config $config)
    {
        $this->file = $file;
        ImageManagerStatic::configure(['driver' => $config->getDriver()]);
        $this->transformFiles();
    }

    /**
     * @param  Closure  $closure
     * @return Image
     */
    abstract public function create($closure = null);

    /**
     * Set file transformations.
     */
    protected function transformFiles()
    {
        /** @var \Illuminate\Support\Collection<int, Image> $images */
        $images = collect();
        foreach ($this->file->getFiles() as $file) {
            if ($file instanceof Image) {
                $images->push($file);
            } else {
                $images->push(ImageManagerStatic::make($file));
            }
        }

        $this->images = $images;
    }

    /**
     * @param  int  $count
     * @return void
     *
     * @throws ImageCountException
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
