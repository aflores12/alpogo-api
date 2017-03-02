<?php

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"name", "stock", "amount", "producer_amount", "start_date", "end_date"}, type="object", @SWG\Xml(name="Ticket"))
 */
class Ticket {

    /**
     * @SWG\Property(example="El ticket de Jhon")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(example="21")
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


    /**
     * @SWG\Property(example="2017/04/09")
     * @var string
     */
    public $start_date;

    /**
     * @SWG\Property(example="2017/04/20")
     * @var string
     */
    public $end_date;


}