<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FeedLastVisitedRooms extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'feed_last_visited_rooms';

    protected $fillable = ['uuid', 'feed_room_id', 'user_id'];


    public function room()
    {
        return $this->belongsTo(FeedRooms::class, 'feed_room_id');
    }
}
