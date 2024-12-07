<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedRoomNote extends Model
{
    protected $fillable = ['feed_room_id', 'user_id', 'note'];

    public function room()
    {
        return $this->belongsTo(FeedRooms::class, 'feed_room_id');
    }
}
