<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopRatedRoom extends Model
{
    use HasFactory;

    protected $with = ['room'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
