<?php

namespace AlpogoApi\Alpogo\Helpers;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 06/02/17
 * Time: 11:40
 */
abstract class ArrayHelper
{

    static public function search_in_array($needle, $array)
    {
        foreach ($array as $key => $value)
        {
            if($key == $needle)
            {
                return true;
            }
        }
        return false;
    }

}