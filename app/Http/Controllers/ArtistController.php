<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\ArtistRepository;
use AlpogoApi\Model\Artist;
use AlpogoApi\Model\User\User;
use Illuminate\Http\Request;

class ArtistController extends ApiController
{

    use ArtistRepository;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @SWG\Get(
     *     path="/artists",
     *     tags={"artists"},
     *     summary="Lista de artistas",
     *     description="Retorna la lista de artistas",
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
        $artists = Artist::all();

        $response = $this->successResponses->respond(
            $artists
        );

        $response->send();
    }

    /**
     * @SWG\Get(
     *     path="/users/{id}/artist",
     *     tags={"artists"},
     *     summary="Detalle de artista de usuario",
     *     description="Retorna el artista de un usuario",
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

        $response = $this->successResponses->respond($user->artist->toArray());

        return $response;
    }

    /**
     * @SWG\Post(
     *     path="/users/{id}/artist/",
     *     tags={"artists"},
     *     operationId="attach_artist_user",
     *     summary="Añade un artista al usuario",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de un usuario",
     *         type="integer",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Artist")
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
     *         response=410,
     *         description="User already has an artist.",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function attach(Request $request, $id)
    {

        $validator = $this->validateArtist($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        $user = User::find($id);

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( count($user->artist) > 0 )
            return $this->errorResponses->userHasAnArtist();

        $artist = Artist::create($request->all());

        $user->artist()->attach($artist);

        $response = $this->successResponses->respondSuccess('Artist created successfully.');

        return $response;

    }

    /**
     * @SWG\Delete(
     *     path="/users/{id}/artist/",
     *     tags={"artists"},
     *     operationId="detach_artist_user",
     *     summary="Sustrae un artista al usuario",
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
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid id",
     *     ),
     *     @SWG\Response(
     *         response=402,
     *         description="User not found",
     *     ),
     *     @SWG\Response(
     *         response=406,
     *         description="Artist not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function detach($id)
    {

        if( ! is_numeric($id))
            return $this->errorResponses->invalidIdSupplied();

        $user = User::find($id);

        if( ! $user )
            return $this->errorResponses->userNotFound();

        if( ! $user->artist )
            return $this->errorResponses->ArtistNotFound();

        $user->artist()->delete();

        $response = $this->successResponses->respondSuccess('Artist detached successfully.');

        return $response;
    }

}
