<?php

namespace reactmay\WoWAuth\Models\Auth;

use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use reactmay\WoWModels\Auth\Account as AccountWoW;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class Account
 *
 * @category Eloquent Model
 * @package  reactmay\WoWAuth\Models\Auth
 * @link     https://github.com/reactmay/wow-auth
 */

class Account extends AccountWoW implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword;

    protected $primaryKey = 'account_id';
        
    function __construct(array $attributes = [])
    {
        $this->hidden[] ='remember_token';

        if(config('wow-auth.passport')){
            $this->hidden[] ='password';
            $this->fillable[] ='password';
        }

        parent::__construct($attributes);

    }

    /**
     * Resolved a User instance by Username
     * @param  Builder $query
     * @param  string $username
     * @return ModelContract
     */
    public function scopeFindByUsername(Builder $query, $username)
    {
        return $query->where('username', '=', $username)->FirstOrFail();
    }

    public function getAuthPassword(){
        return $this->pass_hash;
    }
    
    public function sendPasswordResetNotification($token){
       $this->notify(new ResetPassword($token));
    }
}
