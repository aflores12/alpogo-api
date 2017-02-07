<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 17/01/17
 * Time: 11:42
 */

namespace AlpogoApi\Alpogo\Repositories;

use AlpogoApi\Model\User\AccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

Trait AuthRepository
{

    use AccessTokenRepository;

    /**
     * Realiza validaciones de formulario, y requermientos.
     * @param $request
     * @return mixed
     */
    public function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        return $validator;
    }

    /**
     * Realiza un intento de login
     * @param $email
     * @param $password
     * @return mixed
     */
    public function attemptLogin($email, $password)
    {
        if(Auth::once(['email' => $email, 'password' => $password])) {

            $user = Auth::user();

            $accessToken = $this->getAccessToken($user);

            return $this->successResponses->respondSuccess([
                'message' => 'Login successfully',
                'key' => $accessToken
            ]);

        }

        return $this->errorResponses->failLogin();
    }

    /**
     * Auntentifica un usuario. Concentra validaciones e intentos de login.
     * @param $request
     * @return mixed
     */
    public function authenticate($request)
    {
        $validator = $this->validateLogin($request);
        if($validator->fails())
            return $validator->messages();

        return $this->attemptLogin($request->email, $request->password);
    }

}