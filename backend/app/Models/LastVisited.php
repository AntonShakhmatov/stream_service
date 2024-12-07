<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastVisited extends Model
{
    protected $table = 'last_visited_rooms';

    protected $fillable = ['uuid', 'room_id', 'user_id'];


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
