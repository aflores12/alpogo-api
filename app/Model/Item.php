<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'detail', 'picture', 'stock', 'amount', 'producer_amount'
    ];

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function type()
    {
        return $this->hasOne(ItemType::class);
    }

}
