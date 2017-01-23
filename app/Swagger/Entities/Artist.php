<?php

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"name", "location", "description", "avatar", "imagen_head", "imagen_principal"}, type="object", @SWG\Xml(name="Artist"))
 */
class Artist
{
    /**
     * @SWG\Property()
     * @var string
     */
    public $name;

    /**
     * @SWG\Property()
     * @var string
     */
    public $description;

    /**
     * @SWG\Property()
     * @var string
     */
    public $location;

    /**
     * @SWG\Property()
     * @var string
     */
    public $website;

    /**
     * @SWG\Property()
     * @var string
     */
    public $widget;

    /**
     * @SWG\Property()
     * @var string
     */
    public $social;

    /**
     * @SWG\Property()
     * @var string
     */
    public $avatar;

    /**
     * @SWG\Property()
     * @var string
     */
    public $imagen_head;

    /**
     * @SWG\Property()
     * @var string
     */
    public $imagen_principal;

}