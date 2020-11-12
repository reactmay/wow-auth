<?php

namespace Reactmay\WoWAuth\Guard;

use Illuminate\Auth\SessionGuard;
use Illuminate\Http\Request;
use Illuminate\Session\SessionInterface;
use Illuminate\Contracts\Auth\Guard as IlluminateGuard;

use reactmay\WoWAuth\Providers\AccountProvider;

/**
 * Class WoWGuard
 *
 * @category Session\Guard
 * @package  reactmay\WoWAuth\Guard
 * @link     https://github.com/reactmay/wow-auth
 */

class WoWGuard extends SessionGuard implements IlluminateGuard
{
    /**
     * The AccountProvider instance
     *
     * @var
     */
    protected $provider;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The session used by the guard.
     *
     * @var SessionInterface
     */
    protected $session;

    /**
     * Create a new authentication guard.
     *
     * @param  string  $name
     * @param  AccountProvider  $provider
     * @param  SessionInterface  $session
     * @param  Request  $request
     * @return void
     */
    public function __construct($name,
                                AccountProvider $provider,
                                SessionInterface $session,
                                Request $request = null)
    {
        parent::__construct($name, $provider, $session, $request);
    }
}