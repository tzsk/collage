<?php
namespace Tzsk\Collage\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Collage
 *
 * @see \Tzsk\Collage\MakeCollage
 */
class Collage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'tzsk-collage';
    }
}
