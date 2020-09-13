<?php

namespace Tzsk\Collage\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tzsk\Collage\Collage
 */
class Collage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tzsk-collage';
    }
}
