<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Http\Resources\RoomPreviewWithStatsResource;
use App\Models\Chat;
use App\Models\FeedRooms;
use App\Models\TrendingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TrendingRoomController extends Controller
{
    public function __invoke()
    {
        $redisData = Redis::lrange('trending-rooms', 0, -1);

        if (count($redisData) > 0) {
            return json_decode(unserialize($redisData[0]), true);
        }

        $trending_rooms = collect();
        Chat::query()->get()->each(function ($chatId) use (&$trending_rooms) {
            $chatTopRated = FeedRooms::query()
                ->where('chat', $chatId->id)
                ->where('status','!=', 0)
                ->orderByDesc('view_diff')
                ->limit(10)
                ->get();

            $trending_rooms = $trending_rooms->merge($chatTopRated);
        });

        return $trending_rooms;
    }
}
