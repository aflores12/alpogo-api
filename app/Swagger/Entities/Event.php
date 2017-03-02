<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 13/02/17
 * Time: 11:17
 */

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"title", "short_description", "description", "cover_image", "start_date", "end_date", "age_restiction", "locale", "location"}, type="object", @SWG\Xml(name="Event"))
 */
class Event
{
    /**
     * @SWG\Property(example="Jhon")
     * @var string
     */
    public $title;

    /**
     * @SWG\Property(example="Lorem ipsum")
     * @var string
     */
    public $short_description;

    /**
     * @SWG\Property(example="Lorem ipsum")
     * @var string
     */
    public $description;

    /**
     * @SWG\Property(example="")
     * @var string
     */
    public $cover_image;

    /**
     * @SWG\Property(example="1989/09/04")
     * @var string
     */
    public $start_date;

    /**
     * @SWG\Property(example="1989/09/04")
     * @var string
     */
    public $end_date;

    /**
     * @SWG\Property(example="18")
     * @var string
     */
    public $age_restriction;

    /**
     * @SWG\Property(example="Club Paraguay")
     * @var string
     */
    public $locale;

    /**
     * @SWG\Property(example="Córdoba, Argentina")
     * @var string
     */
    public $location;


}