# PHP Collage Maker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![StyleCI](https://styleci.io/repos/103735431/shield?branch=master)](https://styleci.io/repos/103735431)
[![Build Status](https://travis-ci.org/tzsk/collage.svg?branch=master)](https://travis-ci.org/tzsk/collage)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Build Status](https://scrutinizer-ci.com/g/tzsk/collage/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tzsk/collage/build-status/master)
[![Total Downloads][ico-downloads]][link-downloads]

Create Image Collage with ease now with PHP. This package uses [`intervention/image`](https://github.com/Intervention/image) package to leverage image manipulation.

Using this package is very easy and creating Beautiful Collages are not tough anymore.

> *NOTE:* Currently this package only supports 4 images. You can write your own generator to add 5 if you like.

## Installation

This is a composer package. So just run the below composer command inside your project directory to get it installed.

```bash
composer require tzsk/collage
```

## Configure

> If you are using this package outside laravel then you don't need to do this step.

### config/app.php

> If you are using Laravel 5.5 or higher then you don't need to add the Service Provider and the Alias, because this package supports Package Auto-Discovery.

But if you are using Laravel 5.4 or below make these modifications in the app config file: `config/app.php`.

```php
// Add in the providers array
'providers' => [
    Tzsk\Collage\Provider\CollageServiceProvider::class,
],
// Add in the aliases array
'aliases' => [
    'Collage' => Tzsk\Collage\Facade\Collage::class,
],
```

If you want to use any other driver besides `'gd'` then you have to publish the configuration file:

```bash
php artisan vendor:publish
```

> NOTE: For interactive publishing choose the `Tzsk\Collage\Provider\CollageServiceProvider` option.

You will then have a file in your config directory: `config/collage.php`

If you are using `'imagick'` then you can change it.

## Usage

First you need to have a set of images to make collage of. This package can except many kinds of Targets.

```php
$images = [
    // List of images
    'images/some-image.jpg',
];
```

There are other kinds of image targets supported:

```php
$images = [
    // 1. File Contents
    file_get_contents('some/image/path/or/url'),

    // 2. Direct URLs
    'https://some/image/url',

    // 3. Absolute & Relative Path
    '/some/image/somewhere/on/disk',

    // 4. Intervention\Image\Image Object
    ImageManagerStatic::make('...'),
    // It's Intervention\Image\ImageManagerStatic

    // 5. Or if you are Using Laravel
    Image::make('...'),
    // It's Intervention\Image\Facades\Image
];
```

Depending upon the number of images in the array this package will automatically use the right Generator.

### Examples Outside Laravel

Firstly, use the Class Namespace at the top.

```php
use Tzsk\Collage\MakeCollage;

$collage = new MakeCollage($driver); // Default: 'gd'
```

> The Driver is either 'gd' or 'imagick'. Depending upon which library you are using with PHP. You can customize that. The default is `'gd'`.

#### Create collage with 1 Image

Supported, yes.

```php
$image = $collage->make(400, 400)->from($images);

// Add Padding:
$image = $collage->make(400, 400)->padding(10)->from($images);

// Add Background Color:
$image = $collage->make(400, 400)->padding(10)->background('#000')->from($images);
```

#### Create collage with 2 images

```php
$image = $collage->make(400, 400)->from($images); // Default Alignment: vertical

// Change Alignment:
$image = $collage->make(400, 400)->from($images, function($alignment) {
    $alignment->vertical(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

#### Create collage with 3 images

```php
$image = $collage->make(400, 400)->from($images); // Default Alignment: twoTopOneBottom

// Change Alignment:
$image = $collage->make(400, 400)->from($images, function($alignment) {
    $alignment->twoTopOneBottom(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->oneTopTwoBottom();
    // OR...
    $alignment->oneLeftTwoRight();
    // OR...
    $alignment->twoLeftOneRight();
    // OR...
    $alignment->vertical();
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

#### Create collage with 4 images

```php
$image = $collage->make(400, 400)->from($images); // Default Alignment: grid

// Change Alignment:
$image = $collage->make(400, 400)->from($images, function($alignment) {
    $alignment->grid(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->vertical();
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

### Examples in Laravel

In laravel you already have the Alias for the Collage Maker

```php
use Tzsk\Collage\Facade\Collage;

$image = Collage::make(400, 400)->from($images);
```

The rest of the Features are same as when using in normal php.

#### Create collage with 1 Image

```php
$image = Collage::make(400, 400)->from($images);

// Add Padding:
$image = Collage::make(400, 400)->padding(10)->from($images);

// Add Background Color:
$image = Collage::make(400, 400)->padding(10)->background('#000')->from($images);
```

#### Create collage with 2 images

```php
$image = Collage::make(400, 400)->from($images); // Default Alignment: vertical

// Change Alignment:
$image = Collage::make(400, 400)->from($images, function($alignment) {
    $alignment->vertical(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

#### Create collage with 3 images

```php
$image = Collage::make(400, 400)->from($images); // Default Alignment: twoTopOneBottom

// Change Alignment:
$image = Collage::make(400, 400)->from($images, function($alignment) {
    $alignment->twoTopOneBottom(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->oneTopTwoBottom();
    // OR...
    $alignment->oneLeftTwoRight();
    // OR...
    $alignment->twoLeftOneRight();
    // OR...
    $alignment->vertical();
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

#### Create collage with 4 images

```php
$image = Collage::make(400, 400)->from($images); // Default Alignment: grid

// Change Alignment:
$image = Collage::make(400, 400)->from($images, function($alignment) {
    $alignment->grid(); // Default, no need to have the Closure at all.
    // OR...
    $alignment->vertical();
    // OR...
    $alignment->horizontal();
});
```

> You can also add `padding()` and `background()` here.

## Return Value

The reaturned `$image` is the instance of `Intervention\Image\Image` object.

You can do multiple things with it.

- You can save the final collage.
- You can just use it as a plain response.
- You can crop/resize/colorize and more.

Read more about what you can do in the [Official Documentation](http://image.intervention.io/).

## Create Custom Generators

Creating a generator is very easy. Create a class that extends the abstract class: `Tzsk\Collage\Contracts\CollageGenerator`.

### Example:

```php
use Tzsk\Collage\Contracts\CollageGenerator;

class FiveImage extends CollageGenerator
{
    /**
     * @param Closure $closure
     * @return \Intervention\Image\Image
     */
    public function create($closure = null)
    {
        // Your code to generate the Intervention\Image\Image object
    }
}
```

> NOTE: Take a look at `src/Contracts/CollageGenerator.php` for details about all the things you have access to in the generator class. Also, if you need a refrerence consider looking into: `src/Generators/FourImage.php`.

#### Extend outside laravel

```php
$image = $collage->with([5 => Your\Class\Namespace\FiveImage::class]);
// Here the key is the number of file your generator accepts.
// After this you can continue chaining methods like ->padding()->from() as usual.
```

You can also override existing generators. Let's say you want to have the FourImage generator to behave differently.
You can make your own `MyFourImage` class and add it.

```php
$image = $collage->with([4 => Your\Class\Namespace\MyFourImage::class]);
// It will replace the existing Generator with your own.
// After this you can continue chaining methods like ->padding()->from() as usual.
```

#### Extend in laravel

```php
$image = Collage::with([5 => Your\Class\Namespace\FiveImage::class]);
// Here the key is the number of file your generator accepts.
// After this you can continue chaining methods like ->padding()->from() as usual.
```

You can also override existing generators. Let's say you want to have the FourImage generator to behave differently.
You can make your own `MyFourImage` class and add it.

```php
$image = Collage::with([4 => Your\Class\Namespace\MyFourImage::class]);
// It will replace the existing Generator with your own.
// After this you can continue chaining methods like ->padding()->from() as usual.
```

You can also do this from the `config/collage.php` config file.

There is a `generators` array which is currently empty. You can add your own generators there like below to Replace or add new generators.

```php
'generators' => [
    // It will replace the current FourImage generator.
    4 => Your\Class\Namespace\MyFourImage::class,

    // It will add a new generator.
    5 => Your\Class\Namespace\FiveImage::class,
]
```

## Testing

After Cloning the repository, install all composer dependecies by running: `composer install`.

Then Run Tests:

```bash
composer test
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mailtokmahmed@gmail.com instead of using the issue tracker.

## Credits

- [Kazi Mainuddin Ahmed][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/tzsk/collage.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/tzsk/collage/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/tzsk/collage.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/tzsk/collage.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tzsk/collage.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tzsk/collage
[link-travis]: https://travis-ci.org/tzsk/collage
[link-scrutinizer]: https://scrutinizer-ci.com/g/tzsk/collage/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/tzsk/collage
[link-downloads]: https://packagist.org/packages/tzsk/collage
[link-author]: https://github.com/tzsk
[link-contributors]: ../../contributors
