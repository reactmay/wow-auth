<?php

namespace Vendor\reactmay\WoWAuth\Providers;

use Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

use Illuminate\Contracts\Auth\Guard as IlluminateGuard;
use Illuminate\Contracts\Hashing\Hasher as IlluminateHasher;

use reactmay\WoWAuth\Guard\WoWGuard;
use reactmay\WoWAuth\Hashing\WoWHasher;

use reactmay\WoWAuth\Models\Auth\Account;
use reactmay\WoWAuth\WoW;

/**
 * Class WoWServiceProvider
 *
 * @category Provider
 * @package  reactmay\WoWAuth\Providers
 * @link     https://github.com/reactmay/wow-auth
 */
class WoWAuthServiceProvider extends ServiceProvider
{


    /**
     * Illuminate Filesystem
     *
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct(Application $application)
    {
        parent::__construct($application);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAuthProvider();

        $this->publishConfigs();
        
        $this->publishMigrations();
    }


    /**
     * Publishes the config stub(s)
     *
     * @return void
     */
    protected function publishConfigs()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('wow-auth.php'),
        ]);
    }

    /**
     * Registers the Auth provider for authentication against WoW Account(s).
     * if desired, this can be used as default by changing the value(s) in config auth.php
     *
     * @return void
     */
    protected function registerAuthProvider()
    {
        Auth::provider('wow', function (Application $app) {
            return new AccountProvider($app->make(IlluminateHasher::class), $app->make(Account::class));
        });
    }

    /**
     * Register bindings in the container.
     *
     *
     * @return void
     */
    public function register()
    {
        // Bind and tag our Auth components.
        $this->app->bind(IlluminateHasher::class, WoWHasher::class);
        $this->app->tag(IlluminateHasher::class, 'WoW');

        $this->app->bind(IlluminateGuard::class, WoWGuard::class);
        $this->app->tag(IlluminateGuard::class, 'WoW');

        // $this->app->bind(IlluminateGuard::class, WoWGuard::class);
        $this->app->bind('wow', function(){
            return new WoW();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     *
     * @return array
     */
    public function provides()
    {
        return [
            WoWHasher::class,
            WoWGuard::class
        ];
    }
    
    private function publishMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    private function getMigrationsPath()
    {
        return __DIR__ . '/../../database/migrations/';
    }
}
