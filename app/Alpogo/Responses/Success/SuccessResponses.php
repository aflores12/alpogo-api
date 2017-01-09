<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 12:21
 */

namespace AlpogoApi\Alpogo\Responses\Success;

use AlpogoApi\Alpogo\Responses\Responses as Responses;

class SuccessResponses extends Responses
{

    public function respondSuccess($data)
    {
        return $this->setStatusCode(200)->respond($data);
    }

}