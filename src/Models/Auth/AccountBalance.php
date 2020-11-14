<?php

namespace reactmay\WoWAuth\Models\Auth;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AccountBalance extends Eloquent
{
    protected $connection = 'auth';
    protected $table = 'account_balance';
    public $timestamps = false;

    protected $dates = [
        'vote_last_time'
    ];

    protected $fillable = [
        'donate',
        'vote',
        'vote_last_time',
        'vote_last_type'
    ];
}
