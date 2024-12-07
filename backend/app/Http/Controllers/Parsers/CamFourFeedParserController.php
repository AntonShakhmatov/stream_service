<?php

namespace App\Http\Controllers\Parsers;

use App\Models\Chat;
use App\Models\FeedRooms;
use Illuminate\Support\Facades\Cache;

class CamFourFeedParserController
{
    use HelperTrait;

    public function index()
    {
        $startTime = microtime(true);

        $chatId = Cache::rememberForever('chatCamFour', function () {
            return Chat::query()->whereName('cam4')->value('id');
        });

        $countriesList = $this->getCountryList();

        FeedRooms::query()->where('chat', $chatId)->update(['status' => 0, 'sort_order' => NULL]);

        $data = json_decode(file_get_contents(config("parser.cam4")), true);

        $currentTime = now()->format('d.m.Y H:m:i');
        $orders = range(1, count($data));
        $insert = collect();
        $uniqueIdentifiers = FeedRooms::query()->where('chat', $chatId)->pluck('viewers', 'unique_identifier')->toArray();
        $key = 0;

        collect($data)->sortByDesc('viewers')->each( function ($room) use ($chatId, $countriesList, $currentTime,$orders, $uniqueIdentifiers, &$insert, &$key) {
            $unique = hash("sha256", "{$room['nickname']}_$chatId");
            $data = [
                'chat' => $chatId,
                'username' => $room['nickname'],
                'sort_order' => $orders[$key],
                'unique_identifier' => $unique,
                'last_online' => $currentTime,
                'gender' => $this->getGender($room['gender']),
                'preview_image' => $room['thumb'],
                'location' => $room['country'],
                'flag' => $countriesList[$room['country']] ?? NULL,
                'sex_orientation' => $this->getSexOrientation($room['sex_preference']),
                'status' => $this->getStatus($room['show_type']),
                'viewers' => (int)$room['viewers'],
                'age' => (int)$room['age'],
                'tags' => $room['show_tags'],
                'chat_url' => $room['link'],
                'embed_url' => "https://traffic.pinklabel.com/live-banners?aff_id=6407a2f5c17c861f7f21eb14&site_id=cam4ppl&profile=".$room['nickname']."&live_indicator=top_right&cta_position=bottom&cta_mode=image&cta_src=",
                'hd' => $room['hd_stream'] ?? false,
                'new' => $room['new_performer'],
                'subject' => $room['status'],
                'language' => $this->getCamsodaLang(collect($room['languages'])?->first()),
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
/*

"id" => 50531962
    "nickname" => "chambersecret"
    "gender" => "female"
    "thumb" => "https://snapshots.xcdnpro.com/thumbnails/chambersecret?s=xSRVqECZR3E7DaXKU/R3JcipIrQzt0vovR2yNjXC75M="
    "thumb_big" => "https://snapshots.xcdnpro.com/snapshots/chambersecret?s=xSRVqECZR3E7DaXKU/R3JcipIrQzt0vovR2yNjXC75M="
    "thumb_error" => "https://cam4-static-test.xcdnpro.com/web/images/defaults/default_Female.png"
    "profile_thumb" => "https://cam4-images.xcdnpro.com/022df74e-faf1-4033-9239-dfd059fd247a.jpg"
    "profile_thumb_sfw" => "https://cam4-images.xcdnpro.com/022df74e-faf1-4033-9239-dfd059fd247a.jpg"
    "country" => "co"
    "sex_preference" => "bisexual"
    "link" => "https://cam4com.go2cloud.org/aff_c?offer_id=278&aff_id=4036&url=https%3A%2F%2Fwww.cam4.com%2Fchambersecret%3Fact%3DhasOffers_{transaction_id}_698_700%26aff_id%3 ▶"
    "status" => " #smoke #striptease #blowjob #ass #pussy #threesome #lesbian"
    "viewers" => 226
    "preview_url" => "https://cam4-hls.xcdnpro.com/316/cam4-origin-live/chambersecret-316-0543d8fa-f355-4340-b558-14f005b001d6_aac/playlist.m3u8"
    "daily_award" => false
    "monthly_award" => false
    "hd_stream" => null
    "show_type" => "NORMAL"
    "source" => "external_encoder"
    "private_room" => false
    "new_performer" => false
    "languages" => array:2 [ …2]
    "has_shop_content" => false
    "kiiroo" => true
    "mobile" => false
    "goal" => 0
    "goal_balance" => 0
    "age" => 18
    "show_tags" => array:7 [ …7]
    "broadcast_type" => "male_female_group"
 */
