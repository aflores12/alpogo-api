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
     *     description="Returns list of users",
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="users response"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();

        $response = new JsonResponse([
            'data' => $this->userTransform->transformCollection($users)
        ], 200);

        $response->send();
    }

    public function store(Request $request)
    {

        $validator = $this->validateUser($request);

        if ($validator->fails())
            return new JsonResponse([
                'data' => $validator->messages()
            ], 200);

        $user = User::create($request->all());

        $this->storePassword($user,$request);

        $response = new JsonResponse([
            'data' => 'User create successfully',
            'user' => $user
        ], 200);

        return $response;
    }
    
    public function show($id)
    {
        $user = User::find($id);

        if( ! $user )
            return $this->errorResponses->pageNotFount();

        $response = $this->successResponses->respond(
            [
                'data' => $this->userTransform->transform($user->toArray())
            ]
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
            $this->errorResponses->pageNotFount();

        $response = new JsonResponse([
            'data' => $user->roles->toArray()
        ], 200);

        return $response;

    }

}
