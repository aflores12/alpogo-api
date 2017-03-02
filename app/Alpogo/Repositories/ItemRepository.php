<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 11:35
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait ItemRepository
{

    private $itemRules = [
        'name' => 'required',
        'detail' => 'required',
        'picture' => 'required',
        'stock' => 'required',
        'amount' => 'required',
        'producer_amount' => 'required'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateItem($request)
    {
        $validator = Validator::make($request->all(),
            $this->itemRules
        );

        return $validator;
    }

}