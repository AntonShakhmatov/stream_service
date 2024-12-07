<?php

namespace App\Http\Controllers;

use App\Http\Resources\OnlineTimeResource;
use App\Models\FeedRooms;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OnlineTimeController extends Controller
{
    public function __invoke(FeedRooms $room)
    {
        $online_times = $room->online_times()
            ->whereDate('login_time', '>', Carbon::now()->subDays(30))
            ->orderBy('login_time', 'DESC')
            ->get();

        return OnlineTimeResource::collection($online_times);
    }
}
