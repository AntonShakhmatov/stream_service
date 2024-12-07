<?php

namespace App\Models;



use MongoDB\Laravel\Eloquent\Model;

class FeedRoomOnlineTimes extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'feed_room_online_times';

    protected $fillable = ['feed_room_id','status', 'login_time', 'logout_time'];

    public $timestamps = false;

    protected $casts = [
        'login_time' => 'date:d.m.Y H:i',
        'logout_time' => 'date:d.m.Y H:i'
    ];
}
