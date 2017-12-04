# Opensmarty Image Service

[![Latest Version](https://img.shields.io/github/release/opensmarty/opensmarty-image.svg?style=flat-square)](https://github.com/opensmarty/opensmarty-image/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/opensmarty/opensmarty-image.svg?style=flat-square)](https://packagist.org/packages/opensmarty/opensmarty-image)

Opensmarty Image is a helper service to handle uploaded images and store images without duplicates. 

Build for Laravel and [Opensmarty Starter](https://opensmarty.github.io). 

## Install

### Via Composer

Install composer package to your laravel project

``` bash
composer require opensmarty/opensmarty-image
```

Add Service Provider to `config/app.php`

``` php
    'providers' => [
        ...
        Opensmarty\Image\OpensmartyImageServiceProvider::class,
        ...
    ],
```

Publishing config file. 

``` bash
php artisan vendor:publish
```

After published, config file for Rest Client is `config/opensmarty-image.php`, you will need to config it to use Rest Client.

## Usage

#### Routes

``` php
Route::get('/image/{name}', 'ImageController@showOriginalImage');
Route::post('/image', 'ImageController@postImage');
```

#### Many Imageables

Use on the Model:
```php
    use OpensmartyHasImageablesTrait;
```

Usage:

``` php

/** @var OpensmartyImage $opensmartyImage */
$opensmartyImage = OpensmartyImage::find(1);

/** @var User $user */
$user = User::find(1);

// save image relations smartly with sequence support (recommended)
$user->syncImages([1, 2], ['type' => 'cover', 'data' => json_encode('a')]);

// save image relations via save
$user->images()->save($opensmartyImage, ['type' => 'cover', 'data' => json_encode('a')]);

// save image relations via attach
$user->images()->attach(1, ['type' => 'cover', 'data' => json_encode('a')]);

// update image relations via sync
$user->images()->sync([1]);

// set as main image
$user->setAsMainImage($opensmartyImage);

// set as type main image
$user->setAsTypeMainImage('cover', $opensmartyImage);

// get all images
print_r($user->getImages()->toArray());

// get first main image
print_r($user->getMainImage()->toArray());

// get all main images
print_r($user->getMainImages()->toArray());

// get all type images
print_r($user->getTypeImages('cover')->toArray());

// get all type images and are main images
print_r($user->getTypeMainImages('cover')->toArray());

```

#### Sample Controller File

`app/Http/Controllers/ImageController.php`

``` php
<?php namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Opensmarty\Image\Controllers\OpensmartyImageController;
use Opensmarty\Models\Image\OpensmartyImage;
use Opensmarty\Image\OpensmartyImageService;

class ImageController extends Controller
{

    public function postImage(Request $request)
    {
        $opensmartyImageService = new OpensmartyImageService();
        $file = $request->file('image');

        $opensmartyImage = null;
        try {
            /** @var OpensmartyImage $opensmartyImage */
            $opensmartyImage = $opensmartyImageService->handleUploadedFile($file);
        } catch (Exception $e) {
            return 'Failed to save: ' . $e->getMessage();
        }

        if (!$opensmartyImage) {
            return 'Failed to save uploaded image.';
        }

        $opensmartyImageId = $opensmartyImage->getOpensmartyImageId();
        return 'Saved: ' . $opensmartyImage->getImageUrl();
    }

    public function showOriginalImage($image_name)
    {
        return OpensmartyImageController::showImage('original', $image_name);
    }

}
```

## Testing

``` bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/opensmarty/opensmarty-image/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Opensmarty](https://github.com/opensmarty)
- [All Contributors](https://github.com/opensmarty/opensmarty-image/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
