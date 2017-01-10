<?php

namespace AlpogoApi\Alpogo\Responses\Errors;
use AlpogoApi\Alpogo\Responses\Responses;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 11:34
 */
class ErrorResponses extends Responses
{

    /**
     * @return mixed
     */
    public function pageNotFound()
    {
        return $this->setStatusCode(404)->respondWithError('Page not found.');
    }

    public function userNotFound()
    {
        return $this->setStatusCode(400)->respondWithError('Invalid id supplied.');
    }

}