WoW Authentication for Laravel 5.6 
=======================

Laravel 5.6 package for authentication based on TrinityCore Database.

WoW authentication is based on a sha1 hash of a concatenation of username and password.


Requirements
============

* PHP >= 5.5.9 || 7.0
* reactmay/wow-models >= dev-master
* Laravel => 5.6

Installation
============

    composer require reactmay/wow-auth

* Add the service provider and facade in your config/app.php

Service Provider
```
'providers' => [
    
    [...]
    
    reactmay\WoWAuth\Providers\WoWAuthServiceProvider::class,
    
    [...]
]
```  
Facade
```
'aliases' => [
    
    [...]
    
    'WoWAuth' => reactmay\WoWAuth\Facades\WoW::class,
    
    [...]
]
```  

* Add database connection in you config/database.php
```
'connections' => [

        [...]

        'characters' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_CHARACTERS', 'localhost'),
            'database'  => env('DB_DATABASE_CHARACTERS', 'forge'),
            'username'  => env('DB_USERNAME_CHARACTERS', 'forge'),
            'password'  => env('DB_PASSWORD_CHARACTERS', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'world' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_WORLD', 'localhost'),
            'database'  => env('DB_DATABASE_WORLD', 'forge'),
            'username'  => env('DB_USERNAME_WORLD', 'forge'),
            'password'  => env('DB_PASSWORD_WORLD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'auth' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_AUTH', 'localhost'),
            'database'  => env('DB_DATABASE_AUTH', 'forge'),
            'username'  => env('DB_USERNAME_AUTH', 'forge'),
            'password'  => env('DB_PASSWORD_AUTH', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]

        [...]

    ],
```

* Add variable in your .env and configure it
```
DB_HOST_WORLD=localhost
DB_DATABASE_WORLD=world
DB_USERNAME_WORLD=root
DB_PASSWORD_WORLD=root

DB_HOST_CHARACTERS=localhost
DB_DATABASE_CHARACTERS=characters
DB_USERNAME_CHARACTERS=root
DB_PASSWORD_CHARACTERS=root

DB_HOST_AUTH=localhost
DB_DATABASE_AUTH=auth
DB_USERNAME_AUTH=root
DB_PASSWORD_AUTH=root
```

* Create configuration file and views
```
php artisan vendor:publish --provider="reactmay\WoWAuth\Providers\WoWAuthServiceProvider"
```

* Configure the package in config/wow-auth.php
* Do migrations
```
php artisan migrate
```

**It's done ! You can now use the package**

Configuration
=====


| Configuration | Value type | Default value | Description |
| :-------------:|:-------------:| :-----:| :-----:|
| passport | boolean | false | Active the support of Laravel Passport |

Usage
=====

- Change users providers or create a new one in config/auth.php

```
'providers' => [
        'users' => [
            'driver' => 'wow',
            'model' => reactmay\WoWAuth\Models\Auth\Account::class,
        ],
    ],
```
    
- Add the connection name in passwords reset configuration or create a new one in config/auth.php

```
'passwords' => [
        'users' => [
            'provider' => 'users',
            'connection' => 'auth',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
```

- Create Auth Route in routes/web.php with :

```
WoWAuth::routes(); 
```

FAQ
=====
* Can I active the support of Laravel Passport before a first installation without ?

Yes you can ! Change the configuration value to true and make a refresh of migrations. All accounts created before the 
activation of the support of Laravel Passport must reset their password to use Password Grant Authorization system.