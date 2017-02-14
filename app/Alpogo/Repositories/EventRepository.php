<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 13/02/17
 * Time: 11:27
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait EventRepository
{

    private $eventRules = [
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'start_date' => 'required|date_format:Y/m/d',
        'end_date' => 'required|date_format:Y/m/d',
        'locale' => 'required',
        'location' => 'required'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateEvent($request)
    {
        $validator = Validator::make($request->all(),
            $this->eventRules
        );

        return $validator;
    }

}