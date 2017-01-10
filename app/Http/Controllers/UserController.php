<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\UserRepository;
use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use AlpogoApi\Alpogo\Transformers\UserTransform;
use AlpogoApi\Model\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    use UserRepository;

    /**
     * @var UserTransform
     */
    private $userTransform;

    /**
     * @var ErrorResponses
     */
    private $errorResponses;

    /**
     * @var SuccessResponses
     */
    private $successResponses;

    /**
     * UserController constructor.
     * @param UserTransform $userTransform
     * @param ErrorResponses $errorResponses
     * @param SuccessResponses $successResponses
     */
    public function __construct(
        UserTransform $userTransform,
        ErrorResponses $errorResponses,
        SuccessResponses $successResponses
    )
    {
        $this->successResponses = $successResponses;
        $this->errorResponses = $errorResponses;
        $this->userTransform = $userTransform;
    }

    /**
     * @SWG\Get(
     *     path="/users/",
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
     *     summary="Registrar usuario",
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
        ], 201);

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
     *         response="400",
     *         description="Invalid id supplied",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);

        if( ! $user )
            return $this->errorResponses->userNotFound();

        $response = $this->successResponses->respond(
            $this->userTransform->transform($user->toArray())
        );

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function roles($id)
    {
        $user = User::find($id);

        if( ! $user )
            $this->errorResponses->pageNotFound();

        $response = new JsonResponse([
            'data' => $user->roles->toArray()
        ], 200);

        return $response;

    }

}
