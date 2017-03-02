<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 23/02/17
 * Time: 12:14
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

trait ItemTypeRepository
{
    private $itemTypeRules = [
        'name' => 'required|unique:item_types'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateItemType($request)
    {
        $validator = Validator::make($request->all(),
            $this->itemTypeRules
        );

        return $validator;
    }
}