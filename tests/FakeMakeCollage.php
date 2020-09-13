<?php

namespace Tzsk\Collage\Tests;

use Tzsk\Collage\MakeCollage;

class FakeMakeCollage extends MakeCollage
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $files
     * @return MakeCollage
     */
    public function setFiles(array $files)
    {
        $this->file->setFiles($files);

        return $this;
    }
}
