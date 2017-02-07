<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 16/01/17
 * Time: 11:52
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait ArtistRepository
{

    private $artistRules = [
        'name' => 'required',
        'location' => 'required',
        'description' => 'required',
        'avatar' => 'required',
        'imagen_head' => 'required',
        'imagen_principal' => 'required'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateArtist($request)
    {
        $validator = Validator::make($request->all(),
            $this->artistRules
        );

        return $validator;
    }
}