<?php

namespace AlpogoApi\Http\Controllers;

use AlpogoApi\Alpogo\Repositories\ItemTypeRepository;
use AlpogoApi\Model\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends ApiController
{
    use ItemTypeRepository;

    /**
     * @SWG\Post(
     *     path="/item/type",
     *     tags={"item"},
     *     operationId="add_item_type",
     *     summary="Añade un tipo de item",
     *     description="",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/ItemType")
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
        $validator = $this->validateItemType($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        $item = ItemType::create($request->all());

        return $this->successResponses->createSuccess('Item type create successfully.');

    }

    /**
     * @SWG\Get(
     *     path="/item/type/{slug}",
     *     tags={"item"},
     *     operationId="get_item_type",
     *     summary="Detalle de un tipo de item",
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
     *         response=410,
     *         description="Item Type not found"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show($slug = false)
    {

        $itemType = ItemType::where('slug', $slug)->first();

        if( ! $itemType || ! $slug)
            return $this->errorResponses->itemNotFound();

        return $this->successResponses->respondSuccess([
            'item_type' => $itemType
        ]);

    }

    /**
     * @SWG\Put(
     *     path="/item/type/{slug}",
     *     tags={"item"},
     *     operationId="update_item_type",
     *     summary="Edita un tipo de item",
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
     *         @SWG\Schema(ref="#/definitions/ItemType")
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid input",
     *     ),
     *     @SWG\Response(
     *         response=410,
     *         description="Item Type not found",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request, $slug = false)
    {

        $validator = $this->validateItemType($request);

        if($validator->fails())
            return $this->errorResponses->requiredParameters($validator->messages());

        if( ! $slug )
            return $this->errorResponses->itemTypeNotFound();

        $itemType = ItemType::where('slug', $slug)->first();

        $itemType->update($request->all());

        return $this->successResponses->respond([
            'message' => 'Item type updated successfully.',
            'item_type' => $itemType
        ]);
    }

    /**
     * @SWG\Delete(
     *     path="/item/type/{id}",
     *     tags={"item"},
     *     operationId="destroy_item_type",
     *     summary="Elimina un tipo de item",
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
     *         response=410,
     *         description="Item type not found",
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

        $itemType = ItemType::find($id);

        if( ! $itemType )
            return $this->errorResponses->itemNotFound();

        ItemType::destroy($id);

        return $this->successResponses->respondSuccess('Item deleted successfully');

    }

}
