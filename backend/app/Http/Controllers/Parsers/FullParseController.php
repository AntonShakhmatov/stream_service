<?php

namespace App\Http\Controllers\Parsers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\FeedRooms;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\FeedParserStatistics;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Parsers\HelperTrait;
use App\Http\Controllers\Parsers\StripchatFeedParserController;

class FullParseController extends Controller
{
    use HelperTrait;
    public function __invoke()
    {
        $data = json_decode(file_get_contents(config("parser.central")), true);
        // $filtered = collect($data['data'])->filter(function ($value, $key) {
        //     if(array_key_exists('chat',$value)){
        //         return str_contains($value['chat'], 'strip');
        //     }
        //     return false;
        // });
        // foreach($data as $d){
        //     foreach($d as $a){
        //         Log::info($a['languages']);

        //     }

        // }
        // dd('fefe');
       $livestreams = collect($data['data'])->groupBy('chat');
        $statistic = FeedParserStatistics::create(['start_parse' => now()->format('d.m.Y H:m:i'), 'status' => false]);
        $startTime = microtime(true);

        $chaturbate = $this->parse($livestreams['chaturbate'], "chaturbate");
        $stripchat = $this->parse($livestreams['stripchat'], "stripchat");
        $bongacams = $this->parse($livestreams['bongacams'], "bongacams");
        $myfreecams = $this->parse($livestreams['myfreecams'], "myfreecams");
        $camsoda = $this->parse($livestreams['camsoda'], "camsoda");
        $cam4 = $this->parse($livestreams['cam4'], "cam4");

        // $bongacams = (new ChaturbateFeedParserController($livestreams['bongacams']))->index();
        // $myfreecams = (new ChaturbateFeedParserController($livestreams['myfreecams']))->index();
        // $camsoda = (new ChaturbateFeedParserController($livestreams['camsoda']))->index();
        // $cam4 = (new ChaturbateFeedParserController($livestreams['cam4']))->index();
        $onlineTimes = SaveOnlineTimes::saveOnlineTimes();
        $viewerRecords = SaveFeedRoomViewersController::saveViewersStats();

        $endTime = microtime(true);
        $executionTime = number_format(($endTime - $startTime), 2);
        $feeds = [
            'Chaturbate' => $chaturbate,
            'Bongacams' => $bongacams,
            'Myfreecams' => $myfreecams,
            'Camsoda' => $camsoda,
            'Cam4' => $cam4,
            'Stripchat' => $stripchat,
        ];

        $statistic->update(['feeds' => json_encode($feeds), 'end_parse' => now()->format('d.m.Y H:m:i'), 'parse_time' => $executionTime, 'status' => true]);

        echo "Full parser time: $executionTime <br><br>
            Chats: <br>
            Chaturbate: $chaturbate <br>
            Bongacams: $bongacams <br>
            Myfreecams: $myfreecams <br>
            Camsoda: $camsoda <br>
            Cam4: $cam4 <br>
            Stripchat: $stripchat <br>
            Online times: $onlineTimes <br>
            Viewer records: $viewerRecords <br>";
    }

    public function parse($feed, $chatName)
    {  ini_set("memory_limit", '1G');
        $startTime = microtime(true);

        $chatId = Chat::query()->whereName($chatName)->value('id');

        $countriesList = $this->getCountryList();

        // Reset rooms
        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($feed));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();

        $key = 0;

        $feed->sortByDesc('num_users')->each(function ($room) use ($chatId, $currentTime, $countriesList, $orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['username']}_$chatId");

            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                'language' => $this->getNewLanguage(array_key_exists(0, $room['languages']) ? $room['languages'][0] : 'Other'),
                'status' => $this->getNewStatus($room['status']),
                'ethnicity' => $this->getEthnicity($room['ethnicity']),
                'viewers' => (int)$room['viewers'],
                'subject' => $room['subject'],
                'new' => $room['new'],
                'hd' => $room['hd'],
                'gender' => $room['gender'] === 's' ? 't' : $room['gender'],
                'age' => (int)$room['age'],
                'unique_identifier' => $unique,
                'flag' => $countriesList[$room['location']] ?? NULL,
                'height' => $room['height'],
                'weight' => $room['weight'],
                'hair_color' => $this->getNewHairColor($room['hair_color']),
                'sex_orientation' => $this->getNewSexOrientation($room['sexual_preference']),
                'body_type' => $this->getNewBodyType($room['body_type']),
                'eye_color' => $this->getNewEyeColor($room['eye_color']),
                'bust_penis_size' => $this->getNewBustPenisSize($room['bust_penis_size']),
                'pubic_hair' => $this->getNewPubicHair($room['pubic_hair']),
                'location' => $room['location'],
                'preview_image' => $room['preview_image'],
                'tags' => $room['tags'],
                'cb_followers' => $room['followers'],
                'chat_url' => $room['chat_url'],
                'embed_url' => $room['embed_url'],
                'last_online' => $currentTime,
                'sort_order' => $orders[$key],
            ];
            $key++;
            if (isset($uniqueIdentifiers[$unique])) {

                FeedRooms::query()->where('unique_identifier', $unique)->update(array_merge($data, ['old_viewers' => (int)$uniqueIdentifiers[$unique], 'view_diff' => (int)$data['viewers'] - (int)$uniqueIdentifiers[$unique]]));
            } else {
                $insert->push(array_merge(['first_online' => $currentTime], $data));
            }
        });

        foreach (array_chunk($insert->toArray(), 1000) as $chunk) {

            FeedRooms::insert($chunk);
        }

        $endTime = microtime(true);
        $executionTime = number_format(($endTime - $startTime), 2);
        echo "end of this bru bru", "<br> $executionTime s";
        return "Count rooms: " . count($feed) . "<br> Execution time $executionTime s";
    }
}
