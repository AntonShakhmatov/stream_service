<?php

namespace App\Http\Controllers\Parsers;

use App\Models\Chat;
use App\Models\Country;
use App\Models\CountryAlias;
use App\Models\Status;
use Illuminate\Support\Facades\Redis;

trait HelperTrait
{
    protected function getStatus(mixed $status): int|string
    {

        $statusData = Redis::lrange('statusData', 0, -1);
        if (count($statusData) === 0) {
            $data = Status::query()->pluck('id', 'name')->toArray();
            Redis::lpush('statusData', serialize(json_encode($data)));
        } else {
            $data = json_decode(unserialize($statusData[0]), true);
        }

        switch (strtolower($status)) {
            case "public":
            case "idle":
            case "normal":
                return array_key_exists('free chat', $data) ? $data['free chat'] : '';
            case "away":
                return array_key_exists('away', $data) ? $data['away'] : '';
            case "hidden":
            case "club_show":
                return array_key_exists('club show', $data) ? $data['club show'] : '';
            case "private":
            case "private_show":
                return array_key_exists('private chat', $data) ? $data['private chat'] : '';
            case "true_private":
                return array_key_exists('true private', $data) ? $data['true private'] : '';
            case "group":
                return array_key_exists('group chat', $data) ? $data['group chat'] : '';
            default:
                return array_key_exists('free chat', $data) ? $data['free chat'] : '';
        }
    }

    protected function extractSrcValue(string $chat, string $iframeString)
    {
        // chaturbate = 1
        if ($chat == 1) {
            $pattern = '/src=[\'"]([^\'"]+)[\'"]/';
            if (preg_match($pattern, $iframeString, $matches)) {
                return $matches[1];
            }
        }
        return $iframeString;
    }

    protected function getNewStatus(mixed $status): int|string
    {
        switch (strtolower($status)) {
            case "public":
            case "idle":
            case "normal":
                return 'free chat';
            case "away":
                return 'away';
            case "hidden":
            case "club_show":
                return 'ticket show';
            case "private":
            case "private_show":
                return 'private chat';
            case "true_private":
                return 'true private';
            case "group":
                return 'group show';
            default:
                return 'free chat';
        }
    }
    protected function getCountryList(): array
    {
        $country = Redis::lrange('country', 0, -1);
        $countryAlias = Redis::lrange('countryAlias', 0, -1);

        $countriesList = count($country) === 0 ? $this->setAndReturnCountry() : json_decode(unserialize($country[0]), true);

        $alias = count($countryAlias) === 0 ? $this->setAndReturnCountryAlias() : json_decode(unserialize($countryAlias[0]), true);

        return array_merge($countriesList, $alias);
    }

    private function setAndReturnCountry(): array
    {
        $country = Country::pluck('img_flag', 'name')->toArray();
        Redis::lpush('country', serialize(json_encode($country)));

        return $country;
    }

    private function setAndReturnCountryAlias(): array
    {
        $alias = CountryAlias::join('countries', 'country_aliases.country_id', '=', 'countries.id')
            ->pluck('countries.img_flag', 'country_aliases.name')
            ->toArray();

        Redis::lpush('countryAlias', serialize(json_encode($alias)));

        return $alias;
    }

    protected function getLanguage(string $lang): string
    {
        $languagesToCheck = ["English", "Spanish", "Russian", "French", "German", "Italian", "Dutch", "Portuguese"];
        return in_array(ucwords(strtolower($lang)), $languagesToCheck) ? ucwords(strtolower($lang)) : "Other";
    }


    protected function getNewLanguage(string $lang): string
    {
        $languagesToCheck = ["en" => "English", "es" => "Spanish", "ru" => "Russian", "fr" => "French", "de" => "German", "it" => "Italian", "nl" => "Dutch", "pt" => "Portuguese"];
        return array_key_exists($lang, $languagesToCheck) ? $languagesToCheck[$lang] : "Other";
    }

    protected function getEthnicity(string|null $ethnicity): string
    {
        switch ($ethnicity) {
            case "arab":
                return "Arabian";
            case "asian":
                return "Asian";
            case "indian":
                return "Indian";
            case "middle-eastern":
                return "Middle Eastern";
            case "black-ebony":
                return "Black/Ebony";
            case "hispanic":
                return "Hispanic";
            case "white":
                return "White";
            default:
                return "Other";
        }
    }

    protected function getGender(string|null $gender): string
    {
        switch (strtolower($gender)) {
            case "male":
            case "males":
            case "couple female + male":
                return "m";
            case "female":
            case "couple female + female":
                return "f";
            case "couple":
                return "c";
            case "trans":
                return "t";
            default:
                return "f";
        }
    }

    protected function getBustPenisSize(string|null $bustPenis): string
    {
        switch ($bustPenis) {
            case "Tiny":
                return "Tiny";

            case "Small":
                return "Small";

            case "Average":
            case "Medium": // "Medium" sa mapuje na "Average"
                return "Average";

            case "Big":
            case "Large": // "Large" sa mapuje na "Big"
                return "Big";

            case "Huge":
                return "Huge";

            default:
                return "Other";
        }
    }


    protected function getNewPubicHair(string|null $pubicHair): string
    {
        switch ($pubicHair) {
            case "hairy":
                return "Hairy";
            case "shaved":
                return "Shaved";
            case "trimmed":
                return "Trimmed";
            case "unknown":
            default:
                return "Other";
        }
    }

    protected function getNewBustPenisSize(string|null $bustPenis): string
    {
        switch ($bustPenis) {
            case "tiny":
            case "small":
                return "Small";
            case "medium": // "Medium" sa mapuje na "Average"
                return "Average";
            case "large": // "Large" sa mapuje na "Big"
                return "Big";
            case "huge":
                return "Huge";
            default:
                return "Other";
        }
    }

    protected function getEyeColor(string|null $eye): string
    {
        switch ($eye) {
            case "Black":
                return "Black";
            case "Brown":
                return "Brown";
            case "Blue":
                return "Blue";
            case "Green":
                return "Green";
            case "Hazel":
                return "Hazel";
            case "Gray":
                return "Gray";
            default:
                return "Other";
        }
    }

    protected function getNewEyeColor(string|null $eye): string
    {
        switch ($eye) {
            case "black":
                return "Black";
            case "brown":
                return "Brown";
            case "blue":
                return "Blue";
            case "green":
                return "Green";
            case "hazel":
                return "Hazel";
            case "gray":
                return "Gray";
            case "other":
            case "unknown":
            default:
                return "Other";
        }
    }
    protected function getHairColor(string|null $hair): string
    {
        // Switch pre HairColor
        switch (strtolower($hair)) {
            case "readhead":
            case "red":
                return "Red";
            case "brunette":
                return "Brown";
            case "blonde":
            case "platinum blonde":
                return "Blonde";
            default:
                return "Other";
        }
    }

    protected function getNewHairColor(string|null $hair): string
    {
        // Switch pre HairColor
        switch (strtolower($hair)) {
            case "red":
                return "Red";
            case "black":
                return "Black";
            case "blonde":
                return "Blonde";
            case "brown":
                return "Brown";
            case "unknown":
            case "other":
            default:
                return "Other";
        }
    }

    protected function getSexOrientation(string|null $orientation): string
    {
        switch ($orientation) {
            case "straight":
                return "Straight";
            case "bisexual":
                return "Bisexual";
            case "gay":
                return "Gay/Lesbian";
            case "bi-curious":
                return "Bi-curious";
            default:
                return "Straight";
        }
    }

    protected function getNewSexOrientation(string|null $orientation): string
    {
        switch ($orientation) {
            case "straight":
                return "Straight";
            case "bisexual":
                return "Bisexual";
            case "gay":
                return "Gay/Lesbian";
            case "bicurious":
                return "Bi-curious";
            case "unknown":
                return "Unknown";
            default:
                return "Straight";
        }
    }

    protected function parseHeightAndWeight(string $height): int
    {
        $pattern = '/[0-9]+/';
        if (preg_match_all($pattern, $height, $matches)) {
            // Vezmeme poslednú zhodu (posledné číslo v reťazci)
            return intval($matches[0][count($matches[0]) - 1]);
        }
        return 0;
    }

    protected function getBodyType($bodyType): string|null
    {
        switch ($bodyType) {
            case "Ample":
                return "Curvy";
            case "Athletic":
                return "Athletic";
            case "Average":
                return "Average";
            case "Large":
                return "BBW";
            case "Little in the middle":
                return "Average";
            case "Muscular":
                return "Muscular";
            case "Slim/Petite":
                return "Slim";
            default:
                return null; // Or your default value
        }
    }
    protected function getNewBodyType($bodyType): string|null
    {
        switch ($bodyType) {
            case "curvy":
                return "Curvy";
            case "athletic":
                return "Athletic";
            case "average":
                return "Average";
            case "bbw":
                return "BBW";
            case 'curvy':
                return "Curvy";
            case "muscular":
                return "Muscular";
            case "slim":
                return "Slim";
            case "other":
            case "unknown":
            default:
                return "Other"; // Or your default value
        }
    }
    protected function getCamsodaLang(string|null $lang): string
    {
        switch ($lang) {
            case "en":
                return "English";
            case "es":
                return "Spanish";
            case "ru":
                return "Russian";
            case "fr":
                return "French";
            case "de":
                return "German";
            case "it":
                return "Italian";
            case "nl":
                return "Dutch";
            case "pt":
                return "Portuguese";
            default:
                return "Other";
        }
    }

    protected function getChats($chat): int
    {
        return Chat::query()->where('name', $chat)->value('id');
    }

    protected function getFilterStatuses(string $status): int
    {
        $statusData = Redis::lrange('statusData', 0, -1);

        if (count($statusData) === 0) {
            $data = Status::query()->pluck('id', 'name')->toArray();
            Redis::lpush('statusData', serialize(json_encode($data)));
        } else {
            $data = json_decode(unserialize($statusData[0]), true);
        }

        return $data[$status];
    }

    protected function roomsToHashMap($rooms): array
    {
        $roomMap = [];

        foreach ($rooms as $room) {
            if ($room->chat === "myfreecams" && $room->mfcId !== null) {
                $roomMap[$room->mfcId] = $room;
            } else {
                $roomMap[$room->chat . $room->username] = $room;
            }
        }

        return $roomMap;
    }

    protected function topValuesFromMap($map, $limit): array
    {
        // Zoradenie poľa podľa hodnôt a uchovanie kľúčov
        arsort($map);

        // Získanie top X prvkov z poľa
        $top = array_slice($map, 0, $limit, true);

        return $top;
    }

    public function getNewFilterStatuses(string $status): int
    {
        switch ($status) {
            case "free chat":
                return 1;
            case "group chat":
                return 2;
            case "private chat":
                return 3;
            case "ticket show":
                return 4;
            case "true private":
                return 6;
            case "away":
                return 5;
            default:
                return 0;
        }

        return $data[$status];
    }

    protected function transformGenderFilter(array $gender): array
    {
        return collect($gender)->map(fn($item) => $this->getGender($item))->all();
    }

    protected function transformStatusFilter(array $status): array
    {
        return collect($status)->map(fn($item) => $this->getNewFilterStatuses($item))->all();
    }

    protected function transformChatFilter(array $chat): array
    {
        return collect($chat)->map(fn($item) => $this->getChats($item))->all();
    }
}
