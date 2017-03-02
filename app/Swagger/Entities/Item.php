<?php

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"name", "detail", "picture", "stock", "amount", "producer_amount"}, type="object", @SWG\Xml(name="Item"))
 */
class Item {

    /**
     * @SWG\Property(example="El item de Jhon")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(example="Detalle del item")
     * @var string
     */
    public $detail;


    /**
     * @SWG\Property(example="/var/www/html/picture.jpg")
     * @var string
     */
    public $picture;

    /**
     * @SWG\Property(example="123")
     * @var string
     */
    public $stock;

    /**
     * @SWG\Property(example="123")
     * @var string
     */
    public $amount;


    /**
     * @SWG\Property(example="123")
     * @var string
     */
    public $producer_amount;



}