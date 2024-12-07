<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;


class OnlineTime extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'online_times';

    protected $dates = ['login_time', 'logout_time'];

    protected $casts = [
        'login_time' => 'date:d.m.Y H:i',
        'logout_time' => 'date:d.m.Y H:i'
    ];

    public $timestamps = false;
}
