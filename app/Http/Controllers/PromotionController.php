<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\PromotionRepository;
use AlpogoApi\Model\Event;
use AlpogoApi\Model\Promotion;
use Illuminate\Http\Request;

class PromotionController extends ApiController
{
    use PromotionRepository;

    /**
     * @SWG\Post(
     *     path="/event/{slug}/promotion",
     *     tags={"event"},
     *     operationId="add_promotion_to_event",
     *     summary="Añade una promoción al evento",
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
     *         @SWG\Schema(ref="#/definitions/Promotion")
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
        $validator = $this->validatePromotion($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        $promotion = Promotion::create($request->all());
        $promotion->event_id = $event->id;
        $promotion->save();

        return $this->successResponses->createSuccess('Promotion create successfully.');

    }

    /**
     * @SWG\Get(
     *     path="/event/{slug}/promotion",
     *     tags={"event"},
     *     operationId="get_promotion_from_event",
     *     summary="Añade una promoción al evento",
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
            'promotions' => $event->promotions
        ]);

    }

    /**
     * @SWG\Put(
     *     path="/event/{slug}/promotion/{id}",
     *     tags={"event"},
     *     operationId="update_promotion_of_event",
     *     summary="Edita una promoción de un evento",
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
     *         @SWG\Schema(ref="#/definitions/Promotion")
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

        $validator = $this->validatePromotion($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! $id )
            return $this->errorResponses->ticketNotFound();

        $event = Event::where('slug', $slug)->first();

        if( ! $event || ! $slug)
            return $this->errorResponses->eventNotFound();

        $promotion = Promotion::find($id);

        $promotion->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Promotion updated successfully.',
            'promotion' => $promotion
        ]);
    }

    /**
     * @SWG\Patch(
     *     path="/event/{slug}/promotion/{id}",
     *     tags={"event"},
     *     operationId="partial_update_promotion_of_event",
     *     summary="Edita parcialmente una promoción de un evento",
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
     *         @SWG\Schema(ref="#/definitions/Promotion")
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
    public function partialUpdate(Request $request, $slug, $id)
    {
        if( ! $id )
            return $this->errorResponses->ticketNotFound();

        $event = Event::where('slug', $slug)->first();

        if( ! $event || ! $slug)
            return $this->errorResponses->eventNotFound();

        $promotion = Promotion::find($id);

        $promotion->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Promotion updated successfully.',
            'promotion' => $promotion
        ]);
    }

}
