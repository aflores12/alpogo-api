<?php

namespace AlpogoApi\Alpogo\Responses;
use AlpogoApi\Alpogo\HTTP\HttpCodes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 05/01/17
 * Time: 11:35
 */
abstract class Responses
{

    protected $statusCode = HttpCodes::OK;

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
     * @param $data
     * @return JsonResponse
     */
    public function respond($data)
    {
        $response =  new JsonResponse($data, $this->getStatusCode());

        return $response;
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    protected function respondWithError($message)
    {
        $response =  new JsonResponse([
            'error' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ], $this->getStatusCode());

        return $response;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function respondWithValidator($data)
    {
        $response =  new JsonResponse([
            $data
        ], $this->getStatusCode());

        return $response;
    }

}