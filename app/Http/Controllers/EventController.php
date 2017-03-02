<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Helpers\ImageHelper;
use AlpogoApi\Alpogo\Repositories\EventRepository;
use AlpogoApi\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class EventController extends ApiController
{

    use EventRepository;

    /**
     * @SWG\Get(
     *     path="/event/list",
     *     tags={"event"},
     *     summary="Lista de eventos",
     *     description="Retorna la lista de eventos",
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
        $events = Event::all();
        $response = $this->successResponses->respond(
            $events
        );
        return $response;
    }

    /**
     * @SWG\Post(
     *     path="/event/",
     *     tags={"event"},
     *     operationId="add_event",
     *     summary="Crea un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Event")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = $this->validateEvent($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $image = ImageHelper::base64ToImage($this->imagePath, $request);

        $event = new Event();

        $event->title = $request->title;
        $event->short_description = $request->short_description;
        $event->description = $request->description;
        $event->cover_image = env('APP_URL').$image;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->age_restriction = $request->age_restriction;
        $event->locale = $request->locale;
        $event->location = $request->location;

        $event->save();

        return $this->successResponses->createSuccess('Event create successfully.');

    }

    /**
     * @SWG\Get(
     *     path="/event/{slug}",
     *     tags={"event"},
     *     operationId="show_event",
     *     summary="Detalle de un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         description="",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        return $this->successResponses->respondSuccess([
            'data' => $event
        ]);
    }


    /**
     * @SWG\Put(
     *     path="/event/{slug}",
     *     tags={"event"},
     *     operationId="update_event",
     *     summary="Edita un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         description="",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Event")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=408,
     *         description="Event not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request, $slug)
    {

        $validator = $this->validateEvent($request);

        if ($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        $event->update($request->all());

        return $this->successResponses->respondSuccess([
            'message' => 'Event updated successfully.',
            'data' => $event
        ]);
    }

    /**
     * @SWG\Patch(
     *     path="/event/{slug}",
     *     tags={"event"},
     *     operationId="partial_update_event",
     *     summary="Edita parcialmente un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         description="",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Event")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=408,
     *         description="Event not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function partialUpdate(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        $event->update($request->all());

        return $this->successResponses->respondSuccess([
            'message' => 'Event updated successfully.',
            'data' => $event
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/event/{slug}/items",
     *     tags={"event"},
     *     summary="Lista de items de un evento",
     *     description="Retorna la lista de items de un eventos",
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         description="",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=408,
     *         description="Event not found",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function items($slug)
    {
        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();


        return $this->successResponses->respond([
            'items' => $event->items
        ]);

    }

}
