<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexRoomRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Chat;
use App\Models\Country;
use App\Models\FeedRooms;
use App\Models\Status;
use App\Queries\FuzzyFilter;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class RoomsController extends Controller
{
    public function index(IndexRoomRequest $request)
    {
        $rooms = QueryBuilder::for(FeedRooms::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id',
                    'username',
                    'chat',
                    'gender',
                    'age',
                    'location',
                    'viewers',
                    'status',
                    'new',
                    'likes',
                    'followers'
                )),
                AllowedFilter::exact('chat'),
                AllowedFilter::callback('gender', fn(Builder $query, $gender) => $query->whereIn('gender', $this->transformGenderFilter($gender))),
                AllowedFilter::callback('status', fn(Builder $builder, $value) => $value ? $builder->whereNot('status', 0) : ''),
                AllowedFilter::callback('new', fn(Builder $builder, $val) => $val ? $builder->where('new', 'true') : ''),
            ])
            ->defaultSort('id')
            ->allowedSorts('id', 'username', 'chat', 'gender', 'age', 'location', 'viewers', 'status', 'new', 'language')
            ->paginate($request?->perPage ?? 25)
            ->withQueryString();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms,
            'chats' => Chat::query()->pluck('name', 'id'),
            'statuses' => Status::query()->pluck('name', 'id'),
        ]);
    }

    public function create() {}

    public function store(StoreRoomRequest $request) {}

    public function edit(FeedRooms $room)
    {
        $locations = Country::query()->get(['name'])->flatMap(fn($country) => [$country->name => $country->name]);
        return Inertia::render('Rooms/EditForm', compact('room', 'locations'));
    }

    public function update(UpdateRoomRequest $request, FeedRooms $room)
    {
        $data = $request->validated();
        $room->update($data);

        return redirect()->route('rooms.index')->with(['message' => 'Operation successfully']);
    }


    protected function getGender(string|null $gender): string
    {
        switch (strtolower($gender)) {
            case "male":
            case "males":
                return "m";
            case "female":
                return "f";
            case "couple":
                return "c";
            case "trans":
                return "t";
            default:
                return "";
        }
    }

    protected function transformGenderFilter(string $gender): array
    {
        return collect([$gender])->map(fn($item) => $this->getGender($item))->all();
    }
}
