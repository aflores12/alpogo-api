<?php

namespace AlpogoApi\Model\User;

use AlpogoApi\Model\User\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @SWG\Definition(required={"first_name", "last_name", "email", "passport", "birthday"}, type="object", @SWG\Xml(name="User"))
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name' ,'email', 'passport', 'birthday', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Genera un random Token para validar el registro posteriormente
     * y una fecha de last_login
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
            $user->last_login = date('Y/m/d');
        });

    }

    /**
     * Retorna los roles a los que pertenece el usuario
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
