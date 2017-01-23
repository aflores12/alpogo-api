<?php

namespace AlpogoApi\Swagger\Entities;

/**
 * @SWG\Definition(required={"first_name", "last_name", "email", "passport", "birthday"}, type="object", @SWG\Xml(name="User"))
 */
class User {

    /**
     * @SWG\Property(example="Jhon")
     * @var string
     */
    public $first_name;

    /**
     * @SWG\Property(example="Doe")
     * @var string
     */
    public $last_name;

    /**
     * @SWG\Property(example="jhon@doe.com")
     * @var string
     */
    public $email;

    /**
     * @SWG\Property(example="34335174")
     * @var string
     */
    public $passport;

    /**
     * @SWG\Property(example="1989/04/09")
     * @var string
     */
    public $birthday;

    /**
     * @SWG\Property(example="jhondoe")
     * @var string
     */
    public $password;

    /**
     * @SWG\Property(example="jhondoe")
     * @var string
     */
    public $password_confirmation;

}