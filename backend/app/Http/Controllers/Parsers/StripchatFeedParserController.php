<?php

namespace App\Http\Controllers\Parsers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\FeedRooms;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class StripchatFeedParserController extends Controller
{
    use HelperTrait;

    public Collection $feeds;

    public function __construct($feeds){
        $this->feeds = $feeds;
    }

    public function index()
    {
        $startTime = microtime(true);

        $chatId = Chat::query()->whereName('stripchat')->value('id');

        $countriesList = $this->getCountryList();

        // Reset rooms
        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($this->feeds));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();

        $key = 0;

        $this->feeds->sortByDesc('num_users')->each(function ($room) use ($chatId, $currentTime, $countriesList, $orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['username']}_$chatId");

            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                // TODO languages
                'language' => $this->getLanguage(array_key_exists(0,$room['languages']) ?$room['languages'][0] : ''),
                //TODO status
                'status' => $this->getStatus($room['status']),
                'viewers' => (int)$room['viewers'],
                'subject' => $room['subject'],
                'new' => $room['new'],
                'hd' => $room['hd'],
                'gender' => $room['gender'] === 's' ? 't' : $room['gender'],
                'age' => (int)$room['age'],
                'unique_identifier' => $unique,
                'flag' => $countriesList[$room['location']] ?? NULL,
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
        return "Count rooms: " . count($this->feeds) . "<br> Execution time $executionTime s";
    }
}
