<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\FeedRoomOnlineTimes;
use App\Models\FeedRooms;
use App\Models\FeedRoomViewerRecord;
use App\Models\Room;
use App\Models\TrendingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function setTopRated()
    {
        Redis::del('top-rated');

        $top_rated_rooms = FeedRooms::query()
            ->where('status', '!=', 0)
            ->orderBy('viewers', 'desc')
            ->orderBy('sort_order')
            ->take(10)
            ->get();

        Redis::lpush('top-rated', serialize(json_encode($top_rated_rooms->toArray())));
    }

    public function setTrending()
    {
        Redis::del('trending-rooms');
        $trending_rooms = Chat::query()->get()->map(function ($chatId) use (&$trending_rooms) {
            return FeedRooms::query()
                ->where('chat', $chatId->id)
                ->where('status','!=', 0)
                ->orderByDesc('view_diff')
                ->limit(10)
                ->get();
        });

        Redis::lpush('trending-rooms', serialize(json_encode($trending_rooms->toArray())));
    }

    public function countAllRooms()
    {
        Redis::del('count_all_rooms');
        Redis::lpush('count_all_rooms', FeedRooms::count());
    }

    public function setRooms()
    {
        Redis::del('all_rooms');
        set_time_limit(0);

        $rooms = FeedRooms::query()->where('status','!=', 0)->select([
            'id', 'username', 'chat', 'viewers', 'status', 'preview_image', 'chat_url', 'gender',
            'location','new', 'hd', 'age', 'created_at', 'updated_at','mfc_rank','mfc_score',
            'cb_followers', 'flag','sort_order','subject',
        ])->orderBy('sort_order')->take(100)->get()->toArray();

        Redis::lpush('all_rooms', serialize(json_encode($rooms)));

        $val = Redis::lrange('all_roomst', 0, 99);

        echo "Done count rooms: ".count($val);
    }

    public function renderTags()
    {
        $tags_arrays =  FeedRooms::query()->where("status", '!=', 0)->pluck("tags")->toArray();

        $tags = array();
        foreach ($tags_arrays as $tags_array) {
            $tags = array_merge(str_replace(['[',']'], '', explode(",",$tags_array)));
        }
        dd($tags);
    }
}
