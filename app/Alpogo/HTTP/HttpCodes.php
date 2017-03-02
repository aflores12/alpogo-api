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

    const EVENT_NOT_FOUND = 408;

    const TICKET_NOT_FOUND = 409;

    const ITEM_TYPE_NOT_FOUND = 410;

    const ITEM_NOT_FOUND = 411;

    const ALREADY_HAS = 405;

    const ARTIST_NOT_FOUND = 406;

    const PERMISSION_DENIED = 407;

}