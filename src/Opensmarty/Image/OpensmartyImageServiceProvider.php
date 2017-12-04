<?php

namespace Opensmarty\Image;


use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Opensmarty\Models\Image\OpensmartyImage;

class OpensmartyImageServiceProvider extends ServiceProvider
{
    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (class_exists(OpensmartyImage::class)) {
            Relation::morphMap([
                OpensmartyImage::MORPH_NAME => OpensmartyImage::class,
            ]);
        }
        $this->loadMigrationsFrom(__DIR__.'/../../migrations');
        $this->publishes([
            __DIR__.'/../../config/config.php'               => config_path('opensmarty-image.php'),
            
            // master files
            __DIR__.'/../../master/OpensmartyImage.php.dist' => app_path('Models/Image/OpensmartyImage.php'),
        
        ]);
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'opensmarty-image'
        );
    }
}