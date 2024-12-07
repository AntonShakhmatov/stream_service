<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

// class FeedRoomNote extends Model
// {
//     protected $fillable = ['feed_room_id', 'user_id', 'note'];

//     public function room()
//     {
//         return $this->belongsTo(FeedRooms::class, 'feed_room_id');
//     }
// }

class FeedRoomNote extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'feed_room_notes';

    protected $fillable = ['feed_room_id', 'user_id'];

    public function room()
    {
        return $this->belongsTo(FeedRooms::class, 'feed_room_id', '_id');
    }
}
