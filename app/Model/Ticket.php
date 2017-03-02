<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'stock', 'amount', 'start_date', 'end_date'
    ];

    public function event()
    {
        return $this->hasOne(Event::class);
    }

}
