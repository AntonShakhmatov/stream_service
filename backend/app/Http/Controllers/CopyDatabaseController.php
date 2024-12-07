<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

class CopyDatabaseController extends Controller
{
    public function copyRooms()
    {
        set_time_limit(0);
        for($i=0;$i < 100; $i++) {
            Room::factory()->count(10000)->create();

            print_r(Room::query()->count());
        }

//        DB::connection("sqlite")->table('rooms')->chunkById(100, function ($rooms) {
//
//            collect($rooms)->each(function ($room) {
//                $room = (array)$room;
//                              $data = [
//                    'username' => $room['username'],
//                    'chat' => $room['chat'],
//                    'viewers' => $room['viewers'],
//                    'status' => $room['status'],
//                    'mfc_id' => $room['mfc_id'],
//                    'preview_image' => $room['img'],
//                    'embed_url' => $room['embed'],
//                    'chat_url' => $room['chat_url'],
//                    'gender' => "Male",
//                    'new' => $room['new'],
//                    'hd' => $room['hd'],
//                    'dmca' => $room['DMCA'],
//                    'subject' => $room['subject'],
//                    'age' => $room['age'],
//                    'height' => $room['height'],
//                    'weight' => $room['weight'],
//                    'location' => $room['location'],
//                    'ethnicity' => $room['ethnicity'],
//                    'body_type' => $room['body_type'],
//                    'bust_penis_size' => $room['bust_penis_size'],
//                    'language' => $room['language'],
//                    'secondary_language' => $room['secondary_language'],
//                    'hair_color' => "Black",
//                    'hair_length' => 'Short',
//                    'sex_orientation' => "Other",
//                    'pubic_hair' => $room['pubic_hair'],
//                    'eye_color' => $room['eye_color'],
//                    'cb_followers' => $room['cb_followers'],
//                    'cb_score' => $room['cb_score'],
//                    'mfc_rank' => $room['mfc_rank'],
//                    'mfc_score' => $room['mfc_score'],
//                    'tags' => $room['tags'] ?? json_encode([]),
//                ];
//
//                Room::query()->updateOrInsert([
//                    'username' => $data['username'],
//                    'chat' => $data['chat'],
//                    "mfc_id" => $data['mfc_id']
//                ], $data);
//            });
//        });
    }
}
