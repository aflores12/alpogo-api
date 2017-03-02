<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'detail', 'quantity', 'amount', 'producer_amount', 'active'
    ];

    public function event()
    {
        return $this->hasOne(Event::class);
    }

}
