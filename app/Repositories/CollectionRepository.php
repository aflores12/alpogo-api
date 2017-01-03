<?php

namespace AlpogoApi\Repositories;

Trait CollectionRepository
{

    /**
     * @param $users
     * @return array
     */
    private function transformCollection($users)
    {
        return array_map([$this, 'transform'], $users->toArray());
    }

    /**
     * @param $user
     * @return array
     */
    private function transform($user)
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