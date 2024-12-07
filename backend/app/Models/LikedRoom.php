<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedRoom extends Model
{
    use HasFactory;

    protected $fillable = ['room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
