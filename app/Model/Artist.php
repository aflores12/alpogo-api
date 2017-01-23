<?php

namespace AlpogoApi\Model;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{

    public $timestamps = false;


    protected $table = 'artists';


    protected $fillable = [
        'name', 'slug', 'location', 'website', 'description', 'widget', 'social', 'avatar', 'imagen_head', 'imagen_principal'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = str_slug($user->name);
        });
    }

}
