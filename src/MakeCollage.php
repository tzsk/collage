<?php

namespace Tzsk\Collage;

use Closure;
use Exception;
use Tzsk\Collage\Helpers\Config;
use Tzsk\Collage\Helpers\File;

class MakeCollage
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Collage constructor.
     */
    public function __construct($driver = 'gd')
    {
        $this->bootstrap($driver);
    }

    /**
     * Bootstrap the class
     *
     * @return void
     */
    protected function bootstrap($driver)
    {
        $this->config = new Config($driver);
        $this->file = new File;
    }

    /**
     * @param array $generator
     * @return MakeCollage
     */
    public function with($generator)
    {
        $this->config->setClassMap($generator);

        return $this;
    }

    /**
     * @param int $width
     * @param null|int $height
     *
     * @return MakeCollage
     */
    public function make($width, $height = null)
    {
        $height = $height ? $height : $width;
        $this->file->setWidth($width);
        $this->file->setHeight($height);

        return $this;
    }

    /**
     * @param string $color
     *
     * @return MakeCollage
     */
    public function background($color = null)
    {
        $this->file->setColor($color);

        return $this;
    }

    /**
     * @param int $pixels
     *
     * @return MakeCollage
     */
    public function padding($pixels = 0)
    {
        $this->file->setPadding($pixels);

        return $this;
    }

    /**
     * @param array $files
     *
     * @param Closure $closure
     *
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManagerStatic
     */
    public function from(array $files, $closure = null)
    {
        $this->file->setFiles($files);

        return $this->generate($closure);
    }

    /**
     * @param Closure $closure
     *
     * @return \Intervention\Image\Image|\Intervention\Image\ImageManagerStatic
     * @throws Exception
     */
    protected function generate($closure = null)
    {
        $count = count($this->file->getFiles());

        if (! $this->config->hasGeneratorFor($count)) {
            throw new Exception('Maximum '.$this->config->getGeneratorCount().' Images are allowed');
        }

        $class = $this->config->getGenerator($count);

        return with(new $class($this->file, $this->config))->create($closure);
    }
}
