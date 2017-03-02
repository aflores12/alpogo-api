<?php
/**
 * Created by PhpStorm.
 * User: aflores
 * Date: 11/01/17
 * Time: 11:35
 */

namespace AlpogoApi\Alpogo\Repositories;

use Illuminate\Support\Facades\Validator;

Trait TicketRepository
{

    private $ticketRules = [
        'name' => 'required',
        'stock' => 'required',
        'start_date' => 'required|date_format:Y/m/d',
        'end_date' => 'required|date_format:Y/m/d'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function validateTicket($request)
    {
        $validator = Validator::make($request->all(),
            $this->ticketRules
        );

        return $validator;
    }

}