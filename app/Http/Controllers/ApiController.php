<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 04/01/17
 * Time: 11:20
 */

namespace AlpogoApi\Http\Controllers;


use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{

    protected $errorResponses;

    public function __construct(ErrorResponses $errorResponses)
    {
        $this->errorResponses = $errorResponses;
    }

}