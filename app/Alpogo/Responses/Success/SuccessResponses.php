<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 12:21
 */

namespace AlpogoApi\Alpogo\Responses\Success;

use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Responses\Responses as Responses;

class SuccessResponses extends Responses
{

    public function respondSuccess($data)
    {
        return $this->setStatusCode(HttpCodes::OK)->respond($data);
    }

    public function createSuccess($data)
    {
        return $this->setStatusCode(HttpCodes::CREATE)->respond($data);
    }

}