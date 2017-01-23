<?php

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

Trait UserRepository
{

    /**
     * Reglas de validación
     * @var array
     */
    private $userRules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|unique:users',
        'passport' => 'required|unique:users',
        'birthday' => 'required|date_format:Y/m/d',
        'password' => 'required|min:6|confirmed'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateUser($request)
    {
        $validator = Validator::make($request->all(),
            $this->userRules
        );

        return $validator;
    }


}