<?php

namespace AlpogoApi\Model\User;

use AlpogoApi\Model\Artist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name' ,'email', 'avatar', 'passport', 'birthday', 'password', 'id'
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

        static::deleting(function ($user) {
            $user->artist()->delete();
            $user->roles()->delete();
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

    /**
     * Retorna el artista asociado al usuario
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

    /**
     * Retorna el key asociado al usuario
     * @return mixed
     */
    public function accessToken()
    {
        return $this::hasOne(AccessToken::class);
    }

    /**
     * @param $request
     * @return $this
     */
    public function storePassword($request)
    {
        $this->password = bcrypt($request->password);
        $this->save();

        return $this;
    }

}
