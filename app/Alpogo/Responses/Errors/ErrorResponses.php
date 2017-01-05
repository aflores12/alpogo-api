<?php

namespace AlpogoApi\Alpogo\Responses\Errors;
use AlpogoApi\Alpogo\Responses\Responses;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 11:34
 */
abstract class ErrorResponses extends Responses
{

    public function pageNotFount()
    {
        return $this->getStatusCode(404)->respondWithError('Page not found');
    }

}