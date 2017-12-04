<?php

namespace Opensmarty\Image\Models\Traits;

use Opensmarty\Models\Image\OpensmartyImage;

trait OpensmartyHasOneImageTrait
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function opensmarty_image()
    {
        return $this->hasOne(OpensmartyImage::class, 'opensmarty_image_id', 'opensmarty_image_id');
    }

    /**
     * @return OpensmartyImage|null
     */
    public function getOpensmartyImage()
    {
        return $this->opensmarty_image;
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getOpensmartyImageUrl()
    {
        $opensmartyImageType = $this->getOpensmartyImageType();
        return $this->getOpensmartyImageUrlForType($opensmartyImageType);
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getOpensmartyImageUrlForType($type)
    {
        $opensmartyImage = $this->getOpensmartyImage();
        if (!$opensmartyImage) {
            return $this->getOpensmartyImageDefaultUrl();
        }
        if (!empty($type)) {
            return $opensmartyImage->getTypeImageUrl($type);
        } else {
            return $opensmartyImage->getImageUrl();
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getOpensmartyImageUrlAttribute()
    {
        return $this->getOpensmartyImageUrl();
    }

    /**
     * @return int|null
     */
    public function getOpensmartyImageId()
    {
        return $this->opensmarty_image_id;
    }

    /**
     * @return null|string
     */
    public function getOpensmartyImageName()
    {
        $opensmarty_image = $this->getOpensmartyImage();
        if ($opensmarty_image) {
            return $opensmarty_image->getImageName();
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getOpensmartyImageNameAttribute()
    {
        return $this->getOpensmartyImageName();
    }

    /**
     * @return null
     */
    protected function getOpensmartyImageType()
    {
        return null;
    }

    /**
     * @return null
     */
    protected function getOpensmartyImageDefaultUrl()
    {
        return null;
    }

}