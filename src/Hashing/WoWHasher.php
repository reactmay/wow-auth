<?php

namespace Vendor\reactmay\WoWAuth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as IlluminateHasher;

/**
 * Class WoWHasher
 *
 * @category Hasher
 * @package  reactmay\WoWAuth\Hashing
 * @license  GNU
 * @link     https://github.com/reactmay/wow-auth
 */
class WoWHasher implements IlluminateHasher
{
    /**
     * Hash the given value.
     *
     * @param  mixed  $user
     * @return array   $options
     * @return string
     */
    public function make($data, array $options = array()) {
        if(is_string($data)) {
            if (config('wow-auth.passport'))
                return md5($data);
            else
                throw new \InvalidArgumentException("Cannot create password hash for WoW with only one argument.");
        }
        if(is_array($data))
        {
            // cast $user Array to Object, no need to instantiate a Collection here.
            $data = (object)$data;
        }

        return SHA1(strtoupper($data->username.':'.$data->password));
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = array()) {

        return strtoupper($this->make($value)) === strtoupper($hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array()) {
        return false;
    }
    
    /**
     * Get information about the given hashed value.
     *
     * @param  string $hashedValue
     * @return void
     */
    public function info($hashedValue)
    {
        // TODO: Implement info() method.
    }
}
