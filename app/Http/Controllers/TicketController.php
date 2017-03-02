<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\TicketRepository;
use AlpogoApi\Model\Event;
use AlpogoApi\Model\Ticket;
use Illuminate\Http\Request;

class TicketController extends ApiController
{

    use TicketRepository;

    /**
     * @SWG\Post(
     *     path="/event/{slug}/ticket",
     *     tags={"event"},
     *     operationId="add_ticket_to_event",
     *     summary="Añade un ticket al evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Ticket")
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
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function store(Request $request, $slug)
    {
        $validator = $this->validateTicket($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        $ticket = Ticket::create($request->all());

        $ticket->event_id = $event->id;
        $ticket->save();

        return $this->successResponses->createSuccess('Ticket create successfully.');

    }

    /**
     * @SWG\Get(
     *     path="/event/{slug}/ticket",
     *     tags={"event"},
     *     operationId="get_ticket_from_event",
     *     summary="Añade un ticket al evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show($slug = false)
    {

        $event = Event::where('slug', $slug)->first();

        if( ! $event || ! $slug)
            return $this->errorResponses->eventNotFound();

        return $this->successResponses->respondSuccess([
            'tickets' => $event->tickets
        ]);

    }

    /**
     * @SWG\Put(
     *     path="/event/{slug}/ticket/{id}",
     *     tags={"event"},
     *     operationId="update_ticket_of_event",
     *     summary="Edita un ticket de un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Ticket")
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
     *         response=409,
     *         description="Ticket not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request, $slug = false, $id = false)
    {

        $validator = $this->validateTicket($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! $id )
            return $this->errorResponses->ticketNotFound();

        $event = Event::where('slug', $slug)->first();

        if( ! $event || ! $slug)
            return $this->errorResponses->eventNotFound();

        $ticket = Ticket::find($id);

        $ticket->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Ticket updated successfully.',
            'ticket' => $ticket
        ]);
    }

    /**
     * @SWG\Patch(
     *     path="/event/{slug}/ticket/{id}",
     *     tags={"event"},
     *     operationId="partial_update_ticket_of_event",
     *     summary="Edita parcialmente un ticket de un evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="string",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Ticket")
     *     ),
     *     @SWG\Response(
     *         response=408,
     *         description="Event not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Ticket not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function partialUpdate(Request $request, $slug = false, $id = false)
    {

        if( ! $id )
            return $this->errorResponses->ticketNotFound();

        $event = Event::where('slug', $slug)->first();

        if( ! $event || ! $slug)
            return $this->errorResponses->eventNotFound();

        $ticket = Ticket::find($id);

        $ticket->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Ticket updated successfully.',
            'ticket' => $ticket
        ]);
    }


}
