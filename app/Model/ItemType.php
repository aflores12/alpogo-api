<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->slug = str_slug($item->name);
        });

        static::updating(function ($item) {
            $item->slug = str_slug($item->name);
        });

    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
