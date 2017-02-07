<?php

namespace AlpogoApi\Model\User;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{

    protected $table = 'access_token';

    public $timestamps = false;

    protected $fillable = [
        'key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'access_token_id');
    }

}
