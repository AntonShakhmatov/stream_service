<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FeedRoomViewerRecord extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'feed_room_viewer_records';

    protected $fillable = ['feed_room_id', 'max_viewers', 'avg_viewers', 'num_records', 'date'];

    public $timestamps = false;
}
