<?php

namespace AlpogoApi\Model\User;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $table = 'permissions';

    public $timestamps = false;

    protected $fillable = [
        'name', 'description'
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

}
