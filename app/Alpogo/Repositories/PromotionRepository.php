<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 11:35
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait PromotionRepository
{

    private $promotionRules = [
        'detail' => 'required',
        'quantity' => 'required',
        'amount' => 'required',
        'producer_amount' => 'required'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validatePromotion($request)
    {
        $validator = Validator::make($request->all(),
            $this->promotionRules
        );

        return $validator;
    }

}