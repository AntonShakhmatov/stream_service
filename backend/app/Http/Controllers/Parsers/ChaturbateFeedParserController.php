<?php

namespace App\Http\Controllers\Parsers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\FeedRooms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ChaturbateFeedParserController extends Controller
{
    use HelperTrait;

    public function index()
    {
        $startTime = microtime(true);

        $chatId = Chat::query()->whereName('chaturbate')->value('id');

        $countriesList = $this->getCountryList();

        // Reset rooms
        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $data = json_decode(file_get_contents(config("parser.chaturbate")), true);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($data));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();

        $key = 0;

        collect($data)->sortByDesc('num_users')->each(function ($room) use ($chatId, $currentTime, $countriesList, $orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['username']}_$chatId");

            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                'language' => $this->getLanguage($room['spoken_languages']),
                'status' => $this->getStatus($room['current_show']),
                'viewers' => (int)$room['num_users'],
                'subject' => $room['room_subject'],
                'new' => $room['is_new'],
                'hd' => $room['is_hd'],
                'gender' => $room['gender'] === 's' ? 't' : $room['gender'],
                'age' => (int)$room['age'],
                'unique_identifier' => $unique,
                'flag' => $countriesList[$room['location']] ?? NULL,
                'location' => $room['location'],
                'preview_image' => $room['image_url_360x270'],
                'tags' => $room['tags'],
                'cb_followers' => $room['num_followers'],
                'chat_url' => $room['chat_room_url'],
                'embed_url' => $room['iframe_embed'],
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
        return "Count rooms: " . count($data) . "<br> Execution time $executionTime s";
    }
}
