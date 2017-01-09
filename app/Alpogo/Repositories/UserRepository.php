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
    private $rules = [
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
            $this->rules
        );

        return $validator;
    }

    /**
     * Encripta y guarda el password del usuario
     * @param $user
     * @param $request
     */
    public function storePassword($user, $request)
    {
        $user->password = bcrypt($request->password);
        $user->save();
    }

}