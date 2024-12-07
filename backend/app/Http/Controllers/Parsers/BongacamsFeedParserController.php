<?php

namespace App\Http\Controllers\Parsers;

use App\Models\Chat;
use App\Models\Country;
use App\Models\CountryAlias;
use App\Models\FeedRooms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class BongacamsFeedParserController
{

    use HelperTrait;

    public function index()
    {
        $startTime = microtime(true);

        $chatId = Chat::query()->whereName('bongacams')->value('id');

        $countriesList = $this->getCountryList();

        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $data = json_decode(file_get_contents(config("parser.bongacams")), true);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($data));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();
        $key = 0;

        collect($data)->sortByDesc('members_count')->each(function ($room) use ($chatId, $countriesList, $currentTime, $orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['username']}_$chatId");

            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                'ethnicity' => $this->getEthnicity($room['ethnicity']),
                'status' => $this->getStatus($room['chat_status']),
                'subject' => $room['chat_topic'],
                'gender' => $this->getGender($room['gender']),
                'language' => $this->getLanguage($room['primary_language']),
                'location' => $room['homecountry'],
                'flag' => $countriesList[$room['homecountry']] ?? NULL,
                'viewers' => (int)$room['members_count'],
                'preview_image' => "https:{$room['profile_images']['thumbnail_image_small_live']}",
                'age' => (int)$room['display_age'],
                'bust_penis_size' => $this->getBustPenisSize($room['bust_penis_size']),
                'height' => $this->parseHeightAndWeight($room['height']),
                'weight' => $this->parseHeightAndWeight($room['weight']),
                'chat_url' => $room['chat_url'],
                'embed_url' => $room['embed_chat_url'],
                'hair_color' => $this->getHairColor($room['hair_color']),
                'eye_color' => $this->getHairColor($room['eye_color']),
                'pubic_hair' => $room['pubic_hair'],
                'sex_orientation' => $this->getSexOrientation($room['sexual_preference']),
                'sort_order' => $orders[$key],
                'unique_identifier' => $unique,
                'last_online' => $currentTime,
                'tags' => $room['tags'],
                'hd' => $room['hd_cam'],
                'new' => true,
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
        return "Count rooms: ".count($data). "<br> Execution time $executionTime s";
    }
}
