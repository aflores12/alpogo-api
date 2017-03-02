<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 22/02/17
 * Time: 11:04
 */

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"detail", "quantity", "amount", "producer_amount"}, type="object", @SWG\Xml(name="Promotion"))
 */
class Promotion
{
    /**
     * @SWG\Property(example="El detalle de Jhon")
     * @var string
     */
    public $detail;

    /**
     * @SWG\Property(example="21")
     * @var string
     */
    public $quantity;

    /**
     * @SWG\Property(example="123")
     * @var string
     */
    public $amount;

    /**
     * @SWG\Property(example="1234")
     * @var string
     */
    public $producer_amount;

}