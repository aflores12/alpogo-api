<?php

namespace AlpogoApi\Alpogo\Responses\Errors;

use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Responses\Responses;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 11:34
 */
class ErrorResponses extends Responses
{

    public function pageNotFound()
    {
        return $this->setStatusCode(HttpCodes::PAGE_NOT_FOUND)->respondWithError('Page not found.');
    }

    public function userNotFound()
    {
        return $this->setStatusCode(HttpCodes::USER_NOT_FOUND)->respondWithError('User not found.');
    }

    public function roleNotFound()
    {
        return $this->setStatusCode(HttpCodes::ROLE_NOT_FOUND)->respondWithError('Role not found.');
    }

    public function eventNotFound()
    {
        return $this->setStatusCode(HttpCodes::EVENT_NOT_FOUND)->respondWithError('Event not found.');
    }

    public function itemNotFound()
    {
        return $this->setStatusCode(HttpCodes::EVENT_NOT_FOUND)->respondWithError('Item not found.');
    }

    public function ticketNotFound()
    {
        return $this->setStatusCode(HttpCodes::EVENT_NOT_FOUND)->respondWithError('Ticket not found.');
    }

    public function artistNotFound()
    {
        return $this->setStatusCode(HttpCodes::ARTIST_NOT_FOUND)->respondWithError('Artist not found.');
    }

    public function itemTypeNotFound()
    {
        return $this->setStatusCode(HttpCodes::ARTIST_NOT_FOUND)->respondWithError('Item type not found.');
    }

    public function invalidIdSupplied()
    {
        return $this->setStatusCode(HttpCodes::INVALID_INPUT)->respondWithError('Invalid id supplied.');
    }

    public function failLogin()
    {
        return $this->setStatusCode(HttpCodes::INVALID_INPUT)->respondWithError('Invalid email or password.');
    }

    public function requiredParameters($data)
    {
        return $this->setStatusCode(HttpCodes::INVALID_INPUT)->respondWithValidator($data);
    }

    public function userHasAnArtist()
    {
        return $this->setStatusCode(HttpCodes::ALREADY_HAS)->respondWithError('User already has an artist.');
    }

    public function dontHavePermission()
    {
        return $this->setStatusCode(HttpCodes::PERMISSION_DENIED)->respondWithError('Permission denied.');
    }

}