<?php

namespace AlpogoApi\Alpogo\Transformers;

/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 04/01/17
 * Time: 10:58
 */
class UserTransform extends Transformer
{
    /**
     * @param $user
     * @return array
     */
    public function transform($user)
    {
        return [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'birthday' => $user['birthday'],
            'passport' => $user['passport'],
            'validated' => (boolean) $user['validated']
        ];
    }

}