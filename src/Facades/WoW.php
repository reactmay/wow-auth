<?php

namespace Vendor\reactmay\WoWAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class WoW
 *
 * @category Facade
 * @package  reactmay\WoWAuth\Facades
 * @link     https://github.com/reactmay/wow-auth
 */
class WoW extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'wow'; }


}