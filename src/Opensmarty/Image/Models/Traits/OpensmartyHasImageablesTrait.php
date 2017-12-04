<?php

namespace Opensmarty\Image\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Opensmarty\Models\Image\OpensmartyImage;

trait OpensmartyHasImageablesTrait
{

    /**
     * @return mixed|MorphToMany
     */
    public function images()
    {
        return $this->morphToMany(OpensmartyImage::class, 'imageable', 'opensmarty_imageables', null, 'opensmarty_image_id')
            ->withPivot('sequence', 'is_main', 'type', 'data')
            ->orderBy('sequence', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function main_images()
    {
        return $this->images()->wherePivot('is_main', '=', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function type_images($type)
    {
        return $this->images()->wherePivot('type', '=', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function type_main_images($type)
    {
        return $this->main_images()->wherePivot('type', '=', $type);
    }

    /**
     * @param $opensmarty_image_ids
     * @param array $data
     */
    public function syncImages($opensmarty_image_ids, $data = [])
    {
        $this->images()->detach();
        foreach ($opensmarty_image_ids as $sequence => $opensmarty_image_id) {
            $this->images()->attach($opensmarty_image_id, array_merge([
                'sequence' => $sequence,
            ], $data));
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return OpensmartyImage|null
     */
    public function getMainImage()
    {
        return $this->main_images()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMainImages()
    {
        return $this->main_images()->get();
    }

    /**
     * @param $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTypeImages($type)
    {
        return $this->type_images($type)->get();
    }

    /**
     * @param $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTypeMainImages($type)
    {
        return $this->type_main_images($type)->get();
    }

    /**
     * @param OpensmartyImage $opensmartyImage
     * @return int
     */
    public function setAsMainImage(OpensmartyImage $opensmartyImage)
    {
        $this->images()->rawUpdate(['is_main' => false]);
        return $this->images()->updateExistingPivot($opensmartyImage->getKey(), ['is_main' => true]);
    }

    /**
     * @param string $type
     * @param OpensmartyImage $opensmartyImage
     * @return int
     */
    public function setAsTypeMainImage($type, OpensmartyImage $opensmartyImage)
    {
        $this->type_images($type)->rawUpdate(['is_main' => false]);
        return $this->type_images($type)->updateExistingPivot($opensmartyImage->getKey(), ['is_main' => true]);
    }

    /**
     * @param bool $withOpensmartyImageId
     * @return \Illuminate\Support\Collection
     */
    public function getImageUrls($withOpensmartyImageId = false)
    {
        return $this->getNamedImageUrls('image_url', $withOpensmartyImageId);
    }

    /**
     * @param $imageUrlAttributeName
     * @param bool $withOpensmartyImageId
     * @return \Illuminate\Support\Collection
     */
    public function getNamedImageUrls($imageUrlAttributeName, $withOpensmartyImageId = false)
    {
        $key = $withOpensmartyImageId ? 'opensmarty_image_id' : null;
        return $this->getImages()->pluck($imageUrlAttributeName, $key);
    }

    /**
     * @param $type
     * @param $imageUrlAttributeName
     * @param bool $withOpensmartyImageId
     * @return \Illuminate\Support\Collection
     */
    public function getTypeNamedImageUrls($type, $imageUrlAttributeName, $withOpensmartyImageId = false)
    {
        $key = $withOpensmartyImageId ? 'opensmarty_image_id' : null;
        return $this->getTypeImages($type)->pluck($imageUrlAttributeName, $key);
    }

}