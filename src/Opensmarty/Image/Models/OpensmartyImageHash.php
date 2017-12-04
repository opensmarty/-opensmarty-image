<?php

namespace Opensmarty\Image\Models;

use Opensmarty\Base\Models\BaseModel;
use Opensmarty\Models\Image\OpensmartyImage;

class OpensmartyImageHash extends BaseModel
{

    protected $table = 'opensmarty_image_hashes';

    protected $primaryKey = 'opensmarty_image_hash_id';

    protected $fillable = ['opensmarty_image_id', 'file_sha1'];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(OpensmartyImage::class, 'opensmarty_image_id', 'opensmarty_image_id');
    }

}
