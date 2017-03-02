<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\ItemRepository;
use AlpogoApi\Model\Event;
use AlpogoApi\Model\Item;
use AlpogoApi\Model\ItemType;
use Illuminate\Http\Request;

class ItemController extends ApiController
{

    use ItemRepository;

    /**
     * @SWG\Post(
     *     path="/item/{slug}/{slug_item_type}",
     *     tags={"item"},
     *     operationId="add_item_to_event",
     *     summary="Añade un item al evento",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="slug",
     *         in="path",
     *         type="string",
     *         description="Slug de un evento",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="slug_item_type",
     *         in="path",
     *         type="string",
     *         description="Slug de un tipo de item",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Item")
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
     *         response=410,
     *         description="Item type not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function store(Request $request, $slug, $slug_item_type)
    {
        $validator = $this->validateItem($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $event = Event::where('slug', $slug)->first();

        if( ! $event)
            return $this->errorResponses->eventNotFound();

        $itemType = ItemType::where('slug', $slug_item_type)->first();

        if( ! $itemType)
            return $this->errorResponses->itemTypeNotFound();

        $item = Item::create($request->all());

        $item->event_id = $event->id;
        $item->item_type_id = $itemType->id;
        $item->save();

        return $this->successResponses->createSuccess('Item create successfully.');

    }

    /**
     * @SWG\Get(
     *     path="/item/{id}",
     *     tags={"item"},
     *     operationId="get_item",
     *     summary="Detalle de un item",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=411,
     *         description="Item not found"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show($id = false)
    {
        $item = Item::find($id);

        if( ! $item || ! $id)
            return $this->errorResponses->itemNotFound();

        return $this->successResponses->respondSuccess([
            'item' => $item
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/item/{id}",
     *     tags={"item"},
     *     operationId="update_item",
     *     summary="Edita un item",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
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
     *         @SWG\Schema(ref="#/definitions/Item")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=411,
     *         description="Item not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request, $id = false)
    {

        $validator = $this->validateItem($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! $id )
            return $this->errorResponses->itemNotFound();

        $item = Item::find($id);

        if( ! $item )
            return $this->errorResponses->itemNotFound();

        $item->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Ticket updated successfully.',
            'item' => $item
        ]);
    }

    /**
     * @SWG\Patch(
     *     path="/item/{id}",
     *     tags={"item"},
     *     operationId="partial_update_item",
     *     summary="Edita parcialmente un item",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Item")
     *     ),
     *     @SWG\Response(
     *         response=411,
     *         description="Item not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function partialUpdate(Request $request, $id = false)
    {

        if( ! $id )
            return $this->errorResponses->itemNotFound();

        $item = Item::find($id);

        if( ! $item )
            return $this->errorResponses->itemNotFound();

        $item->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Ticket updated successfully.',
            'item' => $item
        ]);
    }

    /**
     * @SWG\Delete(
     *     path="/item/{id}",
     *     tags={"item"},
     *     operationId="destroy_item",
     *     summary="Elimina un item",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         description="",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=411,
     *         description="Item not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function destroy($id = false)
    {
        if( ! $id )
            return $this->errorResponses->itemNotFound();

        $item = Item::find($id);

        if( ! $item )
            return $this->errorResponses->itemNotFound();

        Item::destroy($id);

        return $this->successResponses->respondSuccess('Item deleted successfully');

    }

}
