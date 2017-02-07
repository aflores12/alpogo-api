<?php

namespace AlpogoApi\Http\Controllers\Auth;

use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Repositories\AuthRepository;
use AlpogoApi\Alpogo\Repositories\UserRepository;
use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use AlpogoApi\Model\User\User;
use Illuminate\Http\Request;
use AlpogoApi\Http\Controllers\Controller;

class AuthController extends Controller
{

    use AuthRepository;
    use UserRepository;

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
     * @SWG\Post(path="/login",
     *   tags={"login"},
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

    /**
     * @SWG\Post(
     *     path="/registration",
     *     tags={"registration"},
     *     operationId="post_user",
     *     summary="Registra un usuario",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Create successfully",
     *     )
     * )
     */
    public function registration(Request $request)
    {
        $validator = $this->validateUser($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $user = User::create($request->all())->storePassword($request);

        $response = $this->successResponses->createSuccess([
            'message' => 'User create successfully',
            'key' => $this->getAccessToken($user)
        ]);

        return $response;
    }

}
