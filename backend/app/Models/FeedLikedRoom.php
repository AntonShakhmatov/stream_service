<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class FeedLikedRoom extends Eloquent
{
    protected $connection = 'mongodb'; // соединение с MongoDB
    protected $collection = 'feed_liked_rooms'; //  коллекция

    protected $fillable = ['feed_room_id', 'user_id'];

    public function room()
    {
        return $this->belongsTo(FeedRooms::class, 'feed_room_id', '_id');
    }
}
