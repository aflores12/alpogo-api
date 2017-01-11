<?php

namespace AlpogoApi\Model\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'slug', 'id'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function findForSlug($slug)
    {
        return Role::where('slug', $slug)->first();
    }

}
