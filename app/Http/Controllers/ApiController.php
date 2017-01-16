<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 04/01/17
 * Time: 11:20
 */

namespace AlpogoApi\Http\Controllers;


use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use AlpogoApi\Alpogo\Transformers\UserTransform;

class ApiController extends Controller
{

    /**
     * @SWG\Swagger(
     *   schemes={"http"},
     *   host="localhost:8000",
     *   basePath="/api/v1/",
     *   @SWG\Info(
     *     title="Alpogo API Documentation",
     *     version="1.0.0"
     *   )
     * )
     */

    protected $errorResponses;

    protected $successResponses;

    public function __construct()
    {
        $this->errorResponses = new ErrorResponses();
        $this->successResponses = new SuccessResponses();
    }

}