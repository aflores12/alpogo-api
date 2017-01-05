<?php

namespace AlpogoApi\Alpogo\Responses;
use Illuminate\Http\JsonResponse;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 11:35
 */
abstract class Responses
{
    protected $statusCode;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    protected function respondWithError($message)
    {
        $response =  new JsonResponse([
            'error' => [
                'message' => $message
            ]
        ], $this->statusCode);

        return $response;
    }

}