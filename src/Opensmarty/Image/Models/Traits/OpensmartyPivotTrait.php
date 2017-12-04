<?php

namespace Opensmarty\Image\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Opensmarty\Models\Image\OpensmartyImage;

trait OpensmartyPivotTrait
{

    /**
     * @return mixed
     */
    public function getPivot()
    {
        return $this->pivot;
    }

    /**
     * @return bool
     */
    public function hasPivot()
    {
        return !empty($this->getPivot());
    }

    /**
     * @return mixed|null
     */
    public function getPivotParent()
    {
        if ($this->hasPivot()) {
            return $this->getPivot()->parent;
        } else {
            return null;
        }
    }

}