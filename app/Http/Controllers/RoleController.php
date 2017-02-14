<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 12:15
 */

namespace AlpogoApi\Http\Controllers;


use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Repositories\AccessTokenRepository;
use AlpogoApi\Alpogo\Repositories\RoleRepository;
use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use AlpogoApi\Model\User\Role;
use AlpogoApi\Model\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends ApiController
{

    use AccessTokenRepository;
    use RoleRepository;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @SWG\Get(
     *     path="/roles",
     *     tags={"roles"},
     *     summary="Lista de roles",
     *     description="Retorna la lista de roles",
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
        $response = $this->successResponses->respond(
            Role::all()
        );
        $response->send();
    }

    /**
     * @SWG\Get(
     *     path="/user/roles",
     *     tags={"user"},
     *     summary="Detalle de roles de usuario",
     *     description="Retorna los roles de un usuario",
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @SWG\Response(
     *         response="402",
     *         description="User not found",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     )
     * )
     */
    public function show(Request $request)
    {
        $user = $this->getUserFromAccessToken($request->header('authorization'));

        if( ! $user )
            return $this->errorResponses->userNotFound();

        $response = new JsonResponse([
            $user->roles->toArray()
        ], HttpCodes::OK);

        return $response;

    }

    /**
     * @SWG\Post(
     *     path="/user/roles/",
     *     tags={"user"},
     *     operationId="attach_role_user",
     *     summary="Añade un rol al usuario",
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
     *         required=true,
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="slug",
     *                 type="string",
     *                 default="string"
     *             ),
     *         ),
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid id",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="User not found",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Role not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function attach(Request $request)
    {

        $validator = $this->validateRole($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $user = $this->getUserFromAccessToken($request->header('authorization'));

        $role = Role::where('slug', $request->slug)->first();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( ! $role )
            return $this->errorResponses->RoleNotFound();

        $user->roles()->attach($role->id);

        $response = $this->successResponses->respondSuccess('Role attached successfully.');

        return $response;

    }

    /**
     * @SWG\Delete(
     *     path="/user/roles/{slug}",
     *     tags={"user"},
     *     operationId="detach_role_user",
     *     summary="Sustrae un rol al usuario",
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
     *         name="slug",
     *         in="path",
     *         description="Slug de un rol",
     *         type="string",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid id",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="User not found",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Role not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function detach(Request $request, $slug)
    {

        $user = $this->getUserFromAccessToken($request->header('authorization'));
        $role = Role::where('slug', $slug)->first();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( ! $role )
            return $this->errorResponses->RoleNotFound();

        $user->roles()->detach($role->id);

        $response = $this->successResponses->respondSuccess('Role detached successfully.');

        return $response;
    }
}