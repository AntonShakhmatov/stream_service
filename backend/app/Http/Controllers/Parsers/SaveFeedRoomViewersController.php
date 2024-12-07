<?php

namespace App\Http\Controllers\Parsers;

use App\Http\Controllers\Controller;
use App\Models\FeedRooms;
use App\Models\FeedRoomViewerRecord;
use Carbon\Carbon;

class SaveFeedRoomViewersController extends Controller
{
    public static function saveViewersStats()
    {
        $startTime = microtime(true);
        $date = now()->format('d.m.Y');

        // Get current records for today
        $crecords = FeedRoomViewerRecord::where('date', $date)->get();
        $crecords_rooms_ids = $crecords->pluck('feed_room_id')->toArray();

        // Get online rooms
        $orooms = FeedRooms::where('status', '!=', 0)->get();
        $orooms_ids = $orooms->pluck('_id')->toArray();

        // Calculate new rooms
        $new_rooms = array_diff($orooms_ids, $crecords_rooms_ids);
        $new_records = [];
        $room_viewers = $orooms->pluck('viewers', '_id')->toArray();

        foreach ($orooms as $oroom) {
            if (in_array($oroom->_id, $new_rooms)) {
                $new_records[] = [
                    'feed_room_id'=> $oroom->_id,
                    'max_viewers' => (int)$oroom->viewers,
                    'avg_viewers' => (int)$oroom->viewers,
                    'num_records' => 1,
                    'date'        => $date,
                ];
            }
        }

        foreach ($crecords as $crecord) {
            if (in_array($crecord->feed_room_id, $orooms_ids)) {
                $avgViewers = round((($crecord->avg_viewers * $crecord->num_records) + $room_viewers[$crecord->feed_room_id]) / ($crecord->num_records + 1));
                $maxViewers = $crecord->max_viewers < $room_viewers[$crecord->feed_room_id] ? $room_viewers[$crecord->feed_room_id] : $crecord->max_viewers;

                FeedRoomViewerRecord::query()->where('feed_room_id', $crecord->feed_room_id)->update([
                    'max_viewers' => (int)$maxViewers,
                    'avg_viewers' => (int)$avgViewers,
                    'num_records' => (int)$crecord->num_records + 1,
                ]);
            }
        }

        // Insert new records in batches with conflict resolution
        $chunks = array_chunk($new_records, 100);
        foreach ($chunks as $chunk) {
            FeedRoomViewerRecord::insert($chunk);
        }

        $endTime = microtime(true);
        $executionTime = number_format(($endTime - $startTime), 2);

        return "Execution time $executionTime s";
    }
}
