<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\EventRepository;
use AlpogoApi\Model\Event;
use Illuminate\Http\Request;

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

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        Event::create($request->all());

        return $this->successResponses->createSuccess('Event create successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @SWG\Put(
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

        if($validator->fails())
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
