<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 11:35
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait RoleRepository
{

    private $roleRules = [
        'slug' => 'required'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateRole($request)
    {
        $validator = Validator::make($request->all(),
            $this->roleRules
        );

        return $validator;
    }

}