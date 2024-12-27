<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class FeedHiddenRooms extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'feed_hidden_rooms';

    protected $fillable = ['feed_room_id', 'user_id'];

    public function room()
    {
        return $this->belongsTo(FeedRooms::class, 'feed_room_id', '_id');
    }
}
