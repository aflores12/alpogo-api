<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Model\User\User;
use AlpogoApi\Repositories\CollectionRepository;
use AlpogoApi\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    use UserRepository;
    use CollectionRepository;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $response = new JsonResponse([
            'data' => $this->transformCollection($users)
        ], 404);

        $response->send();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $userExits = $this->verifyIfUserExists($user);

        if($userExits)
            return $userExits['response'];

        $response = new JsonResponse([
            'data' => $this->transform($user->toArray())
        ], 200);

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

        /**
         * Verfiicar si existe el usuario
         */
        $userExits = $this->verifyIfUserExists($user);


        /**
         * Si el usuario no existe, retornar una jsonResponse
         */
        if($userExits)
            return $userExits['response'];

        $response = new JsonResponse([
            'data' => $user->roles->toArray()
        ], 200);

        return $response;

    }

}
