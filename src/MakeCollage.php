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
     *
     * @param Config $config
     * @param File $file
     */
    public function __construct(Config $config, File $file)
    {
        $this->config = $config;
        $this->file = $file;
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

        if (!$this->config->hasGeneratorFor($count)) {
            throw new Exception("Maximum " . $count . " Images are allowed");
        }

        $class = $this->config->getGenerator($count);

        return with(new $class($this->file, $this->config))->create($closure);
    }
}
