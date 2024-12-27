<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parsers\HelperTrait;
use App\Models\FeedRoomOnlineTimes;
use App\Models\FeedRooms;
use App\Models\FeedRoomViewerRecord;
use App\Models\Room;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redis;


class RoomController extends Controller
{
    use HelperTrait;

    public function index(Request $request)
    {
        set_time_limit(0);
        //        $rooms = Redis::lrange('all_rooms', 0 ,-1);
        //
        //        if (!empty($rooms) && !$request->has('filter')) {
        //            $roomsData = json_decode(unserialize($rooms[0]), true);
        //
        //            $paginator = new LengthAwarePaginator(collect($roomsData)->forPage($request->page ?? 1, 100)->values(), count($roomsData), 100, $request->page ?? 1, [
        //                'path' => request()->url(),
        //                'query' => request()->query(),
        //            ]);
        //
        //            return [
        //                'count_all_rooms' => FeedRooms::query()->count('id'),
        //                'count_all_online' => count($roomsData),
        //                'rooms' => $paginator,
        //                'idem z redisu'
        //            ];
        //        }

        $queryBuilder = QueryBuilder::for(FeedRooms::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'username',
                    'subject',
                )),
                AllowedFilter::callback('showJustHDRooms', fn(Builder $query, $val) => $query->where('hd', $val)),
                AllowedFilter::callback('showJustNewModels', fn(Builder $query, $val) => $query->where('new', $val)),
                AllowedFilter::callback('genders', fn(Builder $query, $gender) => $query->whereIn('gender', $this->transformGenderFilter($gender))),
                AllowedFilter::callback('location', fn(Builder $query, $location) => $query->whereIn('location', $location)),
                AllowedFilter::callback('chats', fn(Builder $query, $value) => $query->whereIn('chat', $this->transformChatFilter($value))),
                AllowedFilter::callback('statuses', fn(Builder $query, $value) => $query->whereIn('status', $value)),
                AllowedFilter::callback('body_types', fn(Builder $query, $value) => $query->whereIn('body_type', $value)),
                AllowedFilter::callback('ethnicity', fn(Builder $query, $value) => $query->whereIn('ethnicity', $value)),
                AllowedFilter::callback('eye_colors', fn(Builder $query, $value) => $query->whereIn('eye_color', $value)),
                AllowedFilter::callback('hair_color', fn(Builder $query, $value) => $query->whereIn('hair_color', $value)),
                AllowedFilter::callback('hair_length', fn(Builder $query, $value) => $query->whereIn('hair_length', $value)),

                AllowedFilter::callback('language', fn(Builder $query, $value) => $query->whereIn('language', $value)),
                AllowedFilter::callback('pb_size', fn(Builder $query, $value) => $query->whereIn('bust_penis_size', $value)),
                AllowedFilter::callback('pubic_hair', fn(Builder $query, $value) => $query->whereIn('pubic_hair', $value)),
                AllowedFilter::callback('sex_orientation', fn(Builder $query, $value) => $query->whereIn('sex_orientation', $value)),
                AllowedFilter::callback('weight', function (Builder $query, $value) {
                    return $query->where(function (Builder $q) use ($value) {
                        foreach ($value as $key => $weight) {
                            if (count(explode('-', $weight)) < 2) {
                                $weight = strpos($weight, '<') !== false ?
                                    "0 - " . str_replace('<', '', $weight) :
                                    str_replace('>=', '', $weight) . " - 999";
                            }
                            $weight = trim(str_replace('kg', '', $weight));
                            $key === 0 ?
                                $q->whereBetween('weight', explode('-', $weight)) :
                                $q->orWhereBetween('weight', explode('-', $weight));
                        }
                    });
                }),
                AllowedFilter::callback('heights', function (Builder $query, $value) {
                    return $query->where(function (Builder $q) use ($value) {
                        foreach ($value as $key => $height) {
                            if (count(explode('-', $height)) < 2) {
                                $height = strpos($height, '<') !== false ?
                                    "0 - " . str_replace('<', '', $height) :
                                    str_replace(':', '', $height) . " - 999";
                            }
                            $height = trim(str_replace('cm', '', $height));
                            $key === 0 ?
                                $q->whereBetween('height', explode('-', $height)) :
                                $q->orWhereBetween('height', explode('-', $height));
                        }
                    });
                }),
                AllowedFilter::callback('ages', function (Builder $query, $value) {
                    return $query->where(function (Builder $q) use ($value) {
                        foreach ($value as $key => $age) {
                            $age = strpos($age, '+') !== false ? str_replace('+', '', $age) . " - 150" : $age;
                            $key === 0 ? $q->whereBetween('age', [(int)explode('-', $age)[0], (int)last(explode('-', $age))]) : $q->orWhereBetween('age', explode('-', $age));
                        }
                    });
                }),
                AllowedFilter::callback('tag', fn(Builder $query, $value) => $query->whereIn('tags', $value)),
            ])->defaultSort('sort_order');

        $rooms = FeedRooms::query()
            ->where('status', 0)
            ->whereNull('chat')
            ->select([
                'id',
                'username',
                'chat',
                'viewers',
                'status',
                'preview_image',
                'chat_url',
                'gender',
                'location',
                'new',
                'hd',
                'age',
                'created_at',
                'updated_at',
                'mfc_rank',
                'mfc_score',
                'cb_followers',
                'flag',
                'sort_order',
                'subject',
                'likes',
                'followers',
                'embed_url'
            ])
            ->paginate(100)
            ->withQueryString();

        return [
            'count_all_rooms' => Redis::lrange('count_all_rooms', 0, 1)[0] ?? 0,
            'count_all_online' => FeedRooms::query()->where('status', "!=", 0)->count('id'),
            'rooms' => $rooms,
        ];
    }


    public function redisTest()
    {
        Redis::flushall();
        set_time_limit(0);
        Room::query()->where('status', '!=', 'offline')->select([
            'id',
            'username',
            'chat',
            'viewers',
            'status',
            'preview_image',
            'chat_url',
            'gender',
            'location',
            'new',
            'hd',
            'age',
            'created_at',
            'updated_at',
            'mfc_rank',
            'mfc_score',
            'cb_followers',
            'cb_score',
            'flag',
            'sort_order',
            'subject',
        ])->get()->map(function ($room) {
            Redis::lpush('rooms', collect($room->toArray()));
        });
        $val = Redis::lrange('rooms', 0, -1);

        echo "Done count rooms: " . count($val);
    }



    public function show(FeedRooms $room)
    {
        return $room->toArray();
    }

    public function wp_api(Request $request)
    {
        return [
            'count_all_rooms' => Room::query()->count('id'),
            'count_all_online' => Room::query()->where('status', "!=", 'offline')->count('id'),
            'rooms' => Room::query()
                ->when(auth()->check(), function ($q) use ($request) {
                    $q->whereNotIn('id', $request->user()->hidden_rooms()->pluck('room_id')->toArray());
                })
                ->when($request->hd == 'true', function ($q) {
                    $q->where('hd', '=', true);
                })
                ->when($request->showJustNewModels   == 'true', function ($q) {
                    $q->where('new', '=', true);
                })
                ->when($request->genders, function ($q, $genders) {
                    $q->whereIn('gender', $genders);
                })
                ->when($request->locations, function ($q, $locations) {
                    $q->whereIn('location', $locations);
                })
                ->when($request->chats, function ($q, $chats) {
                    $q->whereIn('chat', $chats);
                })
                ->when($request->statuses, function ($q, $statuses) {
                    $q->whereIn('status', $statuses);
                })
                ->when($request->ethinicity, function ($q, $ethnicities) {
                    $q->whereIn('ethnicity', $ethnicities);
                })
                ->when($request->body_types, function ($q, $body_types) {
                    $q->whereIn('body_type', $body_types);
                })
                ->when($request->hair_colors, function ($q, $hair_colors) {
                    $q->whereIn('hair_color', $hair_colors);
                })
                ->when($request->hair_lengths, function ($q, $hair_lengths) {
                    $q->whereIn('hair_length', $hair_lengths);
                })
                ->when($request->eye_colors, function ($q, $eye_colors) {
                    $q->whereIn('eye_color', $eye_colors);
                })
                ->when($request->sex_orientations, function ($q, $sex_orientations) {
                    $q->whereIn('sex_orientation', $sex_orientations);
                })
                ->when($request->pubic_Hair, function ($q, $pubic_hairs) {
                    $q->whereIn('pubic_hair', $pubic_hairs);
                })
                ->when($request->pb_size, function ($q, $bust_penis_sizes) {
                    $q->whereIn('pb_size', $bust_penis_sizes);
                })
                ->when($request->language, function ($q, $languages) {
                    $q->where(function ($q) use ($languages) {
                        $q->whereIn('language', $languages)
                            ->orWhereIn('secondary_language', $languages);
                    });
                })
                ->when($request->ages, function ($q, $ages) {
                    $q->where(function ($q) use ($ages) {
                        foreach ($ages as $key => $age) {
                            if ($key == 0) {
                                $q->whereBetween('age', explode('-', $age));
                            } else {
                                $q->orWhereBetween('age', explode('-', $age));
                            }
                        }
                    });
                })
                ->when($request->heights, function ($q, $heights) {
                    $q->where(function ($q) use ($heights) {
                        foreach (json_decode($heights) as $key => $height) {
                            if ($key == 0) {
                                $q->whereBetween('height', $height);
                            } else {
                                $q->orWhereBetween('height', $height);
                            }
                        }
                    });
                })
                ->when($request->weights, function ($q, $weights) {
                    $q->where(function ($q) use ($weights) {
                        foreach (json_decode($weights) as $key => $weight) {
                            if ($key == 0) {
                                $q->whereBetween('weight', $weight);
                            } else {
                                $q->orWhereBetween('weight', $weight);
                            }
                        }
                    });
                })
                ->when($request->tag, function ($q, $tags) {
                    // SQLite doesn't support JSON queries
                    collect($tags)->each(fn($tag) => $q->where('tags', 'like', "%\"$tag\"%"));
                })
                ->when($request->search, function ($q, $key_word) {
                    $q->where('username', 'like', "%$key_word%")
                        ->orWhere('subject', 'like', "%$key_word%");
                })
                ->where('status', '!=', 'offline')
                ->select([
                    'id',
                    'username',
                    'chat',
                    'viewers',
                    'status',
                    'preview_image',
                    'chat_url',
                    'gender',
                    'location',
                    'new',
                    'hd',
                    'age',
                    'created_at',
                    'updated_at',
                    'mfc_rank',
                    'mfc_score',
                    'cb_followers',
                    'cb_score',
                ])
                ->orderBy(DB::raw('-`sort_order`'), 'desc')
                ->paginate($request->perPage ?? 100)
        ];
    }

    public function renderCountryFlags()
    {
        set_time_limit(0);
        $rooms = Room::query()->where('status', '!=', 'offline')
            ->leftJoin('country_aliases', 'country_aliases.name', 'like', 'rooms.location')
            ->select([
                'rooms.id',
                'country_aliases.country_id as country_id'
            ])
            ->get();
        $rooms->each(function ($alias) {
            if ($alias->country_id) {
                $alias->update(['flag' => $alias->country->flag]);
            }
        });

        dd(
            Room::query()->where('status', '!=', 'offline')->count(),
            Room::query()->where('status', '!=', 'offline')->whereNotNull('flag')->count(),
        );
    }

    public function getProfileRoom($id)
    {
        $room = FeedRooms::where('id', $id)->first();

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return response()->json($room);
    }
}
