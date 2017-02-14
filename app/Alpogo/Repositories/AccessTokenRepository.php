<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 06/02/17
 * Time: 10:57
 */

namespace AlpogoApi\Alpogo\Repositories;


use AlpogoApi\Alpogo\Helpers\ArrayHelper;
use AlpogoApi\Model\User\AccessToken;
use AlpogoApi\Model\User\User;

Trait AccessTokenRepository
{

    /**
     * Retorna un KEY asociado a un usuario.
     * @param $user
     * @return mixed
     */
    public function getAccessToken($user)
    {
        if(!$this->hasAccessToken($user))
            return $accessToken = $this->createAccessToken($user);

        return $user->accessToken()->first()->key;
    }

    /**
     * Crea un access token y lo asocia a un usuario.
     * Retorna el key generado.
     *
     * @param $user
     * @return mixed
     */
    private function createAccessToken($user)
    {
        $accessToken =  AccessToken::create(['key' => $this->generateKey()]);
        return $this->attachAccessTokenToUser($user, $accessToken);
    }

    /**
     * Asocia un KEY a un usuario.
     * @param $user
     * @param $accessToken
     * @return mixed
     */
    private function attachAccessTokenToUser($user, $accessToken)
    {
        $accessToken->user()->associate($user->id);
        $accessToken->save();

        return $accessToken->key;

    }

    /**
     * Verifica si el usuario tiene asociado un KEY
     * @param $user
     * @return bool
     */
    public function hasAccessToken($user)
    {
        if(ArrayHelper::search_in_array('key', AccessToken::where('user_id', $user->id)->get())) {
            return true;
        }

        return false;
    }

    /**
     * Devuelve un usuario asociado a una KEY
     * @param $accessToken
     * @return mixed
     */
    public function getUserFromAccessToken($accessToken)
    {
        $user_id = AccessToken::where('key', $accessToken)->first()->user_id;
        $user = User::find($user_id);
        return $user;
    }

    /**
     * Genera un KEY random unico.
     * @return string
     */
    private function generateKey()
    {
        return md5(uniqid(rand(), true));
    }

}