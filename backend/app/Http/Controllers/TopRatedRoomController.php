<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Models\FeedRooms;
use App\Models\Room;
use App\Models\TopRatedRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TopRatedRoomController extends Controller
{
    public function index()
    {
        $redisData = Redis::lrange('top-rated', 0, -1);

        if (count($redisData) > 0) {
            return json_decode(unserialize($redisData[0]), true);
        }

        $top_rated_rooms = FeedRooms::query()
            ->where('status', '!=', 0)
            ->orderBy('viewers', 'DESC')
            ->orderBy('sort_order')
            ->take(10)
            ->get();

        return $top_rated_rooms;
    }
}
