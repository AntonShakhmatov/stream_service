<?php

namespace App\Http\Controllers\Parsers;

use App\Models\Chat;
use App\Models\FeedRooms;
use Carbon\Carbon;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Cache;

class MyfreecamsFeedParserController
{

    use HelperTrait;


    public function index()
    {
        $startTime = microtime(true);

        $chatId = Cache::rememberForever('chatMyfreecams', function () {
            return Chat::query()->whereName('myfreecams')->value('id');
        });

        $countriesList = $this->getCountryList();

        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $data = json_decode(file_get_contents(config("parser.myfreecams")), true);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($data['models']));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();
        $key = 0;

        collect($data['models'])->sortByDesc('num_users')->each(function ($room) use ($chatId,$countriesList, $orders, $currentTime, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['id']}_$chatId");
            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                'mfc_id' => $room['id'],
                'mfc_rank' => $room['rank'],
                'mfc_score' => $room['score'],
                'viewers' => (int)$room['num_users'],
                'status' => $this->getStatus($room['status']),
                'preview_image' => $room['avatar'],
                'chat_url' => $room['chat_room_url'],
                'subject' => $room['room_subject'],
                'age' => (int)$room['age'],
                'location' => $room['location'],
                'flag' => $countriesList[$room['location']] ?? NULL,
                'height' => $room['height'] ? $this->parseHeightAndWeight($room['height']) : NULL,
                'weight' => $room['weight'] ? $this->parseHeightAndWeight($room['weight']) : NULL,
                'hair_color' => $this->getHairColor($room['hair']),
                'sex_orientation' => $this->getSexOrientation($room['sexual_preference']),
                'body_type' => $this->getBodyType($room['body_type']),
                'eye_color' => $this->getEyeColor($room['eyes']),
                'ethnicity' => $this->getEthnicity($room['ethnic']),
                'tags' => $room['tags'],
                'sort_order' => $orders[$key],
                'unique_identifier' => $unique,
                'last_online' => $currentTime,
                'hd' => true,
                'new' => true,
                'gender' => "f",
                'embed_url' => $room['chat_room_url'],
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
        return "Count rooms: ".count($data['models']). "<br> Execution time $executionTime s";
    }

}
