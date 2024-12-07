<?php

namespace App\Http\Controllers\Parsers;

use App\Models\FeedRoomOnlineTimes;
use App\Models\FeedRooms;
use App\Models\Room;
use App\Models\OnlineTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaveOnlineTimes
{

    public static function saveOnlineTimes()
    {
        $startTime = microtime(true);
        // Online rooms IDs
        $orooms_ids = FeedRooms::where('status', '!=', 0)->pluck('id')->toArray();

        // End online time for every offline room
        FeedRoomOnlineTimes::whereNull('logout_time')->whereNotIn('feed_room_id', $orooms_ids)
            ->update(['logout_time' => now()->format('d.m.Y H:m:i')]);

        $room_status = FeedRoomOnlineTimes::whereNull('logout_time')
            ->get(['feed_room_id', 'status'])
            ->pluck('status', 'feed_room_id')
            ->toArray();

        // Getting the rooms which are not offline
        $orooms = FeedRooms::where('status', '!=', 0)->get();

        $new_otimes = [];
        foreach ($orooms as $oroom) {
            if (isset($room_status[$oroom->id]) && $room_status[$oroom->id] == $oroom->status) {
                continue;
            }

            $new_otimes[] = [
                'feed_room_id' => $oroom->id,
                'status' => $oroom->status,
                'login_time' => now()->format('d.m.Y H:m:i'),
            ];
        }

        FeedRoomOnlineTimes::insert($new_otimes);

        $endTime = microtime(true);
        $executionTime = number_format(($endTime - $startTime), 2);

        return "Execution time: $executionTime";
    }
}
