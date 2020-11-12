<?php

namespace Reactmay\WoWAuth\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\User;
use reactmay\WoWAuth\Models\Auth\Account;

/**
 * Class AccountProvider
 *
 * @category Provider
 * @package  reactmay\WoWAuth\Providers
 * @link     https://github.com/reactmay/wow-auth
 */
class AccountProvider extends EloquentUserProvider
{
    public function __construct(Hasher $hasher, UserContract $model)
    {
        parent::__construct($hasher, $model);
    }
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {

        $password = $credentials['password'];
        $username = array_key_exists('username', $credentials) ? $credentials['username'] : $this->model->whereEmail($credentials['email'])->FirstOrFail()->username;

        return $this->hasher->check(compact('username', 'password'), $user->getAuthPassword());
    }


    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        return $this->model;
    }

}