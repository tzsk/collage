# collage

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Create Image Collage with ease now with Laravel 5. This package uses [`intervention/image`](https://github.com/Intervention/image) package to leverage image manipulation.
Using this package is very easy and creating Beautiful Collages are not tough anymore.

**Note:** This package only supports up to 4 images right now. Will increase the compatibility as we go along.

## Install

Via Composer

``` bash
$ composer require tzsk/collage
```

## Configure

Then add the Service Provider and Alias in your `config/app.php` file:

```php
'providers' => [
    ...
    Tzsk\Collage\Provider\CollageServiceProvider::class,
    ...
],

'aliases' => [
    ...
    'Collage' => Tzsk\Collage\Facade\Collage::class,
    ...
],
```

Now publish the config file. Via terminal run:

``` bash
$ php artisan vendor:publish --tag=config
```

Inside the Config file you can change the Image Manipulation Driver to either `gd` (default) or `imagick`.

## Usage

Use the class namespace where you want to create collage in your code. ( A controller file )

``` php
...
use Tzsk\Collage\Facade\Collage;
...
```

Then in the method create a `$images` array. This array can be an array of `Image` object from `intervention/image`, 
or Stream array, or URL, or Image Path.

Example:

```php
$images = $request->images; # Directly from the array of upload object.

# OR it can be mixed...

$images = [
    Image::make('images/some-image.jpg'),
    'images/some-other-image.png',
    'http://example.com/image.jpg',
    file_get_contents('...')
];
```

Now, there are several configurations available most of them are optional. Below is the full syntax.

```php
$collage = Collage::make(400, 400)
    ->padding(10)
    ->background('#f00')
    ->from($images, function ($layout) {
        ...
    });
```

Before you jump in and use the package you should know about the API available in above syntax.

1. `make($width, $height)` - `$width Integer`, `$height Integer` : 
    This is mandatory. You have to specify the Canvas width and height you want to create Collage on.
    
2. `padding($number)` - `$number Integer` :
    This is Optional. used for the Padding between the Images and the Sides.
    
3. `background($hexCode)` - `$hexCode String` :
    This is Optional. Used for background color.
    
4. `from($images, Closure $closure)` - `$images Array`, `$closure Closure (Optional)` :
    Images array is mandatory, but the `$closure` is not. In the closure there is a $layout object is passed as an argument.
    
**Note:** The `$layout` object changes as the number of Images present in the `$images` array changes.

For **`One Image`**: You don't really need to specify the Closure at all.



For **`Two Image`**: You have two options in the `$layout` object.

- `$layout->horizontal()`: Default, Aligns the images horizontally.
- `$layout->vertical()`: Aligns the images vertically

Example:

```php
$collage = Collage::make(400, 400)
    ->from($images, function ($layout) {
        $layout->vertical();
    });
```



For **`Three Image`**: You have 4 Options in the `$layout` object.

- `$layout->twoTopOneBottom()`: Default, Two images on the top, side by side. One wide image at the bottom.
- `$layout->oneTopTwoBottom()`: Two images on the bottom, side by side. One wide image at the top.
- `$layout->twoLeftOneRight()`: Two images on the left, one below the other. One tall image at the right.
- `$layout->oneLeftTwoRight()`: Two images on the right, one below the other. One tall image at the left.
   
Example:

```php
$collage = Collage::make(400, 400)
    ->from($images, function ($layout) {
        $layout->oneLeftTwoRight();
    });
```

For **`Four Image`**: You don't really need to specify the Closure at all. It will come as a grid.

**Return Value:**

It returns the Intervention Image Object you can `save()`, `response()` or do whatever you can do with Intervention Image.

Visit: [Intervention Image Documentation](http://image.intervention.io) to know more.

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
