<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Country;
use App\Models\FeedRooms;
use App\Models\OnlineTime;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\FeedParserStatistics;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\RedisController;
use App\Http\Controllers\Parsers\SaveOnlineTimes;
use App\Http\Controllers\Parsers\FullParseController;
use App\Http\Controllers\Parsers\ParserFunctionsController;
use App\Http\Controllers\Parsers\CamFourFeedParserController;
use App\Http\Controllers\Parsers\CamsodaFeedParserController;
use App\Http\Controllers\Parsers\BongacamsFeedParserController;
use App\Http\Controllers\Parsers\SaveFeedRoomViewersController;
use App\Http\Controllers\Parsers\ChaturbateFeedParserController;
use App\Http\Controllers\Parsers\MyfreecamsFeedParserController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Parsers\HelperTrait;
use App\Http\Controllers\Parsers\StripchatFeedParserController;

class FeedParserParseAllCommand extends Command
{
    use HelperTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed-parser:parse-all {--seed-country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run feed parser';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set("memory_limit", '1G');
        //        if (Carbon::parse(FeedParserStatistics::query()->latest('id')->value('start_parse'))->addSeconds(90)->isFuture()) {
        //            echo "Is in the future";
        //            return 0;
        //        }
        if ($this->option('seed-country')) {
            $img_flags = array_diff(scandir(public_path('flags')), ['.', '..']);

            Country::all()->each(function ($item) use ($img_flags) {
                $country_slug = Str::slug(Str::lower($item->name)) . ".png";

                if (in_array($country_slug, $img_flags)) {
                    $item->update(['img_flag' => $country_slug]);
                } elseif ($country_slug === 'ivory-coast.png') {
                    $item->update(['img_flag' => 'cote-divoire.png']);
                } else {
                    dd($item->name, $item, $country_slug);
                }
            });

            return 0;
        }


        // if (FeedParserStatistics::query()->where('status', false)->count()) {
        //     $feed = FeedParserStatistics::query()->where('status', false)->first();
        //     if (!Carbon::parse($feed->start_parse)->addMinutes(5)->isFuture()) {
        //         $this->info('future');
        //         $feed->update(['end_parse' => now()->format('d.m.Y H:i:s')]);
        //         FeedParserStatistics::query()->where('status', false)->update(['status' => true, 'feeds' => json_encode(['forced' => 'status']), 'parse_time' => -1]);
        //     } else {
        //         $this->info('skipped');
        //         FeedParserStatistics::create([
        //             'status' => true,
        //             'feeds' => json_encode(['skipped' => 'true']),
        //             'start_parse' => now()->format('d.m.Y H:i:s'),
        //             'end_parse' => now()->format('d.m.Y H:i:s'),
        //             'parse_time' => 0,
        //         ]);
        //         return 0;
        //     }
        // }

        $statistic = FeedParserStatistics::create(['start_parse' => now()->format('d.m.Y H:i:s'), 'status' => false]);
        $startTime = microtime(true);

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
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $stripchat = $this->parse($livestreams['stripchat'], "stripchat");
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $bongacams = $this->parse($livestreams['bongacams'], "bongacams");
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $myfreecams = $this->parse($livestreams['myfreecams'], "myfreecams");
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $camsoda = $this->parse($livestreams['camsoda'], "camsoda");
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $cam4 = $this->parse($livestreams['cam4'], "cam4");
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $chaturbate = (new ChaturbateFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $bongacams = (new BongacamsFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $myfreecams = (new MyfreecamsFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $camsoda = (new CamsodaFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $cam4 = (new CamFourFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $onlineTimes = SaveOnlineTimes::saveOnlineTimes();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $viewerRecords = SaveFeedRoomViewersController::saveViewersStats();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');

        // $chaturbate = (new ChaturbateFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $bongacams = (new BongacamsFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $myfreecams = (new MyfreecamsFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $camsoda = (new CamsodaFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        // $cam4 = (new CamFourFeedParserController())->index();
        // $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $onlineTimes = SaveOnlineTimes::saveOnlineTimes();
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');
        $viewerRecords = SaveFeedRoomViewersController::saveViewersStats();
        $this->info((memory_get_peak_usage(true) / 1024 / 1024) . ' MB');

        $endTime = microtime(true);
        $executionTime = number_format(($endTime - $startTime), 2);

        $feeds = [
            'Chaturbate' => $chaturbate,
            'Bongacams' => $bongacams,
            'Myfreecams' => $myfreecams,
            'Camsoda' => $camsoda,
            'Cam4' => $cam4,
            'Online times' => $onlineTimes,
            'Viewer records' => $viewerRecords,
        ];

        $statistic->update(['feeds' => json_encode($feeds), 'end_parse' => now()->format('d.m.Y H:i:s'), 'parse_time' => $executionTime, 'status' => true]);

        (new RedisController())->setTopRated();
        (new RedisController())->setTrending();
        (new RedisController())->countAllRooms();
        //        (new RedisController())->setRooms();

        $this->info("Full parser time: $executionTime <br><br>
            Chats: <br>
            Chaturbate: $chaturbate <br>
            Bongacams: $bongacams <br>
            Myfreecams: $myfreecams <br>
            Camsoda: $camsoda <br>
            Cam4: $cam4 <br>
            Online times: $onlineTimes <br>
            Viewer records: $viewerRecords <br>");
        return 0;
    }

    public function parse($feed, $chatName)
    {
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
                'language' => $this->getNewLanguage(array_key_exists(0,$room['languages']) ?$room['languages'][0] : 'Other'),
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
