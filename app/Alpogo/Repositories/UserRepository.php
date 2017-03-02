<?php

namespace AlpogoApi\Alpogo\Repositories;

use AlpogoApi\Alpogo\Helpers\ImageHelper;
use AlpogoApi\Model\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

Trait UserRepository
{

    protected $imagePath = '/images/users/';

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

    public function updateUser($request)
    {

        $image = ImageHelper::base64ToImage($this->imagePath, $request);

        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->passport = $request->passport;
        $user->birthday = $request->birthday;
        $user->avatar = $image;

        return $user;

    }


}