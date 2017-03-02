<?php

namespace AlpogoApi\Alpogo\Helpers;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 06/02/17
 * Time: 11:40
 */

abstract class ImageHelper
{

    static public function base64ToImage($path, $request)
    {

        $image = base64_decode($request->cover_image);

        $image_name = str_slug($request->title) . '-' . date('Y-m-d-H:i:s') . '.jpg';

        $realPath = public_path() . $path . $image_name;

        file_put_contents($realPath, $image);

        return $path . $image_name;

    }


}