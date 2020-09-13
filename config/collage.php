<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | This value determines the driver to be used for image handling.
    | Possible options:
    | "gd" : For Default GD Library.
    | "imagick" : For Imagick Library
    |
    */

    'driver' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Array of custom Generators
    |--------------------------------------------------------------------------
    |
    | This value determines if you are using any custom generators or override
    | any existing generators.
    |
    | This array should contain key value pairs. Where the key denoting
    | the number of images it will accept. And the value denoting the
    | class path of the Generator.
    |
    */
    'generators' => [
        // Example: If you have a generator class for 5 images in App\Collage\FiveImage
        // 5 => App\Collage\FiveImage::class,
    ],
];
