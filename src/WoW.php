<?php

namespace reactmay\WoWAuth;

use Illuminate\Support\Facades\Route;

class WoW{

    public function routes(){
        Route::group([], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }

}