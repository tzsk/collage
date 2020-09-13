<?php

namespace Tzsk\Collage\Helpers;

use Tzsk\Collage\Generators\FourImage;
use Tzsk\Collage\Generators\OneImage;
use Tzsk\Collage\Generators\ThreeImage;
use Tzsk\Collage\Generators\TwoImage;

class Config
{
    /**
     * @var array
     */
    protected $classMap = [
        1 => OneImage::class,
        2 => TwoImage::class,
        3 => ThreeImage::class,
        4 => FourImage::class,
    ];

    /**
     * @var string
     */
    protected $driver;

    /**
     * Config constructor.
     */
    public function __construct($driver = null)
    {
        $this->driver = $driver ?: 'gd';
    }

    /**
     * @param array $maps
     *
     * @return Config
     */
    public function setClassMap($maps)
    {
        foreach ($maps as $key => $map) {
            $this->classMap[$key] = $map;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * @param mixed $count
     *
     * @return bool
     */
    public function hasGeneratorFor($count)
    {
        return isset($this->classMap[$count]);
    }

    /**
     * @return int
     */
    public function getGeneratorCount()
    {
        return count($this->classMap);
    }

    /**
     * @param mixed $index
     *
     * @return mixed
     */
    public function getGenerator($index)
    {
        return $this->classMap[$index];
    }

    /**
     * @param string $driver
     * @return Config
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
