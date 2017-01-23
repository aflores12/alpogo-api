<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 17/01/17
 * Time: 11:42
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

Trait AuthRepository
{

    public function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        return $validator;
    }

    public function attemptLogin($email, $password)
    {
        if(Auth::once(['email' => $email, 'password' => $password]))
            return $this->successResponses->respondSuccess([
                'message' => 'Login successfully',
                'user' => Auth::user()
            ]);

        return $this->errorResponses->failLogin();
    }

    public function authenticate($request)
    {
        $validator = $this->validateLogin($request);
        if($validator->fails())
            return $validator->messages();

        return $this->attemptLogin($request->email, $request->password);
    }

}