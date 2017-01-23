<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Repositories\AuthRepository;
use AlpogoApi\Alpogo\Repositories\UserRepository;
use AlpogoApi\Alpogo\Transformers\UserTransform;
use AlpogoApi\Model\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    use UserRepository;
    use AuthRepository;

    /**
     * @var UserTransform
     */
    private $userTransform;

    /**
     * UserController constructor.
     * @param UserTransform $userTransform
     */
    public function __construct(UserTransform $userTransform)
    {
        parent::__construct();
        $this->userTransform = $userTransform;
    }

    /**
     * @SWG\Get(
     *     path="/users",
     *     tags={"users"},
     *     summary="Lista de usuarios",
     *     description="Retorna la lista de usuarios",
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();

        $response = $this->successResponses->respond(
            $this->userTransform->transformCollection($users)
        );

        $response->send();
    }

    /**
     * @SWG\Post(
     *     path="/users",
     *     tags={"users"},
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
    public function store(Request $request)
    {
        $validator = $this->validateUser($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $user = User::create($request->all())->storePassword($request);

        $response = new JsonResponse([
            'message' => 'User create successfully',
            'user' => $user
        ], HttpCodes::CREATE);

        return $response;
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Detalle de usuario",
     *     description="Retorna el detalle de un usaurio",
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de un usuario",
     *         type="integer",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Invalid id supplied",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     ),
     *     @SWG\Response(
     *         response="402",
     *         description="User not found",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        $response = $this->successResponses->respond(
            $this->userTransform->transform($user->toArray())
        );

        return $response;
    }

    /**
     * @SWG\Put(
     *     path="/users/{id}",
     *     tags={"users"},
     *     operationId="put_user",
     *     summary="Edita un usuario",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de un usuario",
     *         type="integer",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid id supplied",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="User not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        $user->update($request->all());

        $response = new JsonResponse([
            'message' => 'User updated successfully',
            'user' => $user
        ], HttpCodes::OK);

        return $response;
    }


}
