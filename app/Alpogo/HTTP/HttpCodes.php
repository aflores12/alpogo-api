<?php

namespace AlpogoApi\Alpogo\HTTP;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 12:34
 */
abstract class HttpCodes
{

    const OK = 200;

    const CREATE = 201;

    const INVALID_INPUT = 400;

    const INVALID_ID = 401;

    const USER_NOT_FOUND = 402;

    const ROLE_NOT_FOUND = 403;

    const PAGE_NOT_FOUND = 404;

}