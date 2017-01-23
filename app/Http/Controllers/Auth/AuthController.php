<?php

namespace AlpogoApi\Http\Controllers\Auth;

use AlpogoApi\Alpogo\Repositories\AuthRepository;
use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use Illuminate\Http\Request;
use AlpogoApi\Http\Controllers\Controller;

class AuthController extends Controller
{

    use AuthRepository;

    protected $errorResponses;

    protected $successResponses;

    public function __construct(
        ErrorResponses $errorResponses,
        SuccessResponses $successResponses
    )
    {
        $this->errorResponses = $errorResponses;
        $this->successResponses = $successResponses;
    }

    /**
     * @SWG\Post(path="/users/login",
     *   tags={"users"},
     *   summary="Logs user into the system",
     *   description="",
     *   operationId="loginUser",
     *   produces={"application/xml", "application/json"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="The user email for login",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     description="The password for login in clear text",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="successful operation",
     *     @SWG\Schema(type="string"),
     *     @SWG\Header(
     *       header="X-Rate-Limit",
     *       type="integer",
     *       format="int32",
     *       description="calls per hour allowed by the user"
     *     ),
     *     @SWG\Header(
     *       header="X-Expires-After",
     *       type="string",
     *       format="date-time",
     *       description="date in UTC when token expires"
     *     )
     *   ),
     *   @SWG\Response(response=400, description="Invalid username/password supplied")
     * )
     */
    public function login(Request $request)
    {
        return $this->authenticate($request);
    }

}
