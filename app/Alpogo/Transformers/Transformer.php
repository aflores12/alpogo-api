<?php

namespace AlpogoApi\Alpogo\Transformers;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 04/01/17
 * Time: 10:57
 */
abstract class Transformer
{

    /**
     * @param $items
     * @return array
     */
    public function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items->toArray());
    }

    /**
     * @param $item
     * @return mixed
     */
    abstract function transform($item);

}