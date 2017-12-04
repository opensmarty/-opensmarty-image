<?php

namespace Opensmarty\Image\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Opensmarty\Image\OpensmartyImageService;

class OpensmartyImageController extends BaseController
{

    /**
     * @param $template
     * @param $image_name
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public static function showImage($template, $image_name)
    {
        $opensmartyImageService = new OpensmartyImageService();
        return $opensmartyImageService->showImage($template, $image_name);
    }

}
