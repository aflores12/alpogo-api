<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'title', 'short_description', 'description', 'start_date', 'end_date', 'locale', 'location', 'created_at', 'updated_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->slug = str_slug($event->title);
        });

        static::updating(function ($event) {
            $event->slug = str_slug($event->title);
        });

    }

}
