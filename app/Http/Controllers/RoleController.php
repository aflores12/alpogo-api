<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 12:15
 */

namespace AlpogoApi\Http\Controllers;


use AlpogoApi\Alpogo\HTTP\HttpCodes;
use AlpogoApi\Alpogo\Repositories\RoleRepository;
use AlpogoApi\Alpogo\Responses\Errors\ErrorResponses;
use AlpogoApi\Alpogo\Responses\Success\SuccessResponses;
use AlpogoApi\Model\User\Role;
use AlpogoApi\Model\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends ApiController
{

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
        $roles = Role::all();

        $response = $this->successResponses->respond(
            $roles
        );

        $response->send();
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}/roles",
     *     tags={"roles"},
     *     summary="Detalle de roles de usuario",
     *     description="Retorna los roles de un usuario",
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
     *         description="Invalid id",
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

        $response = new JsonResponse([
            $user->roles->toArray()
        ], HttpCodes::OK);

        return $response;

    }

    /**
     * @SWG\Post(
     *     path="/users/{id}/roles/",
     *     tags={"roles"},
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
    public function attach(Request $request, $id)
    {

        $validator = $this->validateRole($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        $user = User::find($id);

        $role = Role::where('slug', $request->slug)->first();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( ! $role )
            return $this->errorResponses->RoleNotFound();

        $user->roles()->attach($role->id);

        $response = new JsonResponse([
            'Role attached successfully.'
        ], HttpCodes::OK);

        return $response;

    }

    /**
     * @SWG\Delete(
     *     path="/users/{id}/roles/{slug}",
     *     tags={"roles"},
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
    public function detach($id, $slug)
    {

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        $user = User::find($id);
        $role = Role::where('slug', $slug)->first();

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( ! $role )
            return $this->errorResponses->RoleNotFound();

        $user->roles()->detach($role->id);

        $response = new JsonResponse([
            'Role detached successfully.'
        ], HttpCodes::OK);

        return $response;
    }
}