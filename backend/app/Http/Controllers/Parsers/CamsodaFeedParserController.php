<?php

namespace App\Http\Controllers\Parsers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\FeedRooms;
use Illuminate\Support\Facades\Cache;

class CamsodaFeedParserController extends Controller
{

    use HelperTrait;

    public function index()
    {
        $startTime = microtime(true);
        $chatId = Cache::rememberForever('chatCamsoda', function () {
            return Chat::query()->whereName('camsoda')->value('id');
        });

        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $data = json_decode(file_get_contents(config("parser.camsoda")), true);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($data['results']));

        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();
        $key = 0;

        collect($data['results'])->sortByDesc('viewers')->each(function ($room) use ($chatId, $currentTime, $orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['username']}_$chatId");
            $data = [
                'chat' => $chatId,
                'username' => $room['username'],
                'sort_order' => $orders[$key],
                'unique_identifier' => $unique,
                'last_online' => $currentTime,
                'status' => $this->getStatus($room['status']),
                'subject' => $room['subject'],
                'viewers' => (int)$room['viewers'],
                'gender' => $room['gender'],
                'language' => isset($room['language'][0]) ? $this->getCamsodaLang($room['language'][0]) : "Other",
                'tags' => $room['tags'],
                'new' => $room['is_new'],
                'hd' => true,
                'preview_image' => $room['thumb'],
                'chat_url' => $room['link'],
                'embed_url' => $room['link_iframe'],
            ];
            $key++;

            if (isset($uniqueIdentifiers[$unique])) {
                FeedRooms::query()->where('unique_identifier', $unique)->update(array_merge($data, ['old_viewers' => (int)$uniqueIdentifiers[$unique], 'view_diff' => (int)$data['viewers'] - (int)$uniqueIdentifiers[$unique]]));
            } else  {
                $insert->push(array_merge(['first_online' => $currentTime], $data));
            }
        });

        foreach (array_chunk($insert->toArray(), 1000) as $chunk) {
            FeedRooms::insert($chunk);
        }

        $endTime = microtime(true);

        $executionTime = number_format(($endTime - $startTime), 2);
        echo "end of this bru bru", "<br> $executionTime s";
        return "Count rooms: ".count($data['results']). "<br> Execution time $executionTime s";
    }
}
