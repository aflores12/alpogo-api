<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 23/02/17
 * Time: 12:15
 */

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"name"}, type="object", @SWG\Xml(name="ItemType"))
 */
class ItemType
{

    /**
     * @SWG\Property(example="jhondoe")
     * @var string
     */
    public $name;


}