<?php

namespace Opensmarty\Image\Models;


use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Opensmarty\Base\Models\BaseModel;
use Opensmarty\Image\Models\Traits\OpensmartyPivotTrait;

class OpensmartyImageBase extends BaseModel implements Transformable, Presentable
{
    use OpensmartyPivotTrait;
    use PresentableTrait;

    const MORPH_NAME = 'OpensmartyImage';

    protected $table = 'opensmarty_images';

    protected $primaryKey = 'opensmarty_image_id';

    protected $fillable = [
        'user_id', 'image_name', 'exif', 'is_gif', 'file_size', 'width', 'height'
    ];

    protected $hidden = [
        'created_at', 'created_by', 'created_ip',
        'updated_at', 'updated_by', 'updated_ip',
    ];

    /**
     * @return Int
     */
    public function getOpensmartyImageId()
    {
        return $this->opensmarty_image_id;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->image_name;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->file_size > 0;
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        return $this->getTypeImageUrl();
    }

    /**
     * @return null|string
     */
    public function getImageUrlAttribute()
    {
        return $this->getImageUrl();
    }

    /**
     * @param $type
     * @return null|string
     */
    public function getTypeImageUrl($type = null)
    {
        $type = $type ? $type . '/' : null;

        if ($this->isValid()) {
            return url('/image/' . $type . $this->getImageName());
        } else {
            return $this->getDefaultImageUrl($type = null);
        }
    }

    /**
     * @param null $type
     * @return null|string
     */
    public function getDefaultImageUrl($type = null)
    {
        return null;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        $storage_path = config("opensmarty-image.storage_path");
        return $storage_path . $this->getImageName();
    }

    /**
     * @return array
     */
    public function transform()
    {
        return [
            'opensmarty_image_id' => $this->getOpensmartyImageId(),
            'image_name' => $this->getImageName(),
        ];
    }

    /**
     * @return array
     */
    public function toSimpleArray()
    {
        $opensmartyImage = $this;
        return [
            'opensmarty_image_id' => $opensmartyImage->getOpensmartyImageId(),
            'opensmarty_image_url' => $opensmartyImage->getImageUrl(),
            'thumbnail_image_url' => $opensmartyImage->getTypeImageUrl('thumbnail'),
        ];
    }

}
