<?php

namespace App\Http\Controllers;

use App\Http\Requests\LastVisitedIndexRequest;
use App\Http\Requests\LastVisitedStoreRequest;
use App\Models\FeedLastVisitedRooms;
use App\Models\LastVisited;
use Illuminate\Http\Request;

class LastVisitedController extends Controller
{
    public function index(LastVisitedIndexRequest $request)
    {
        if ($request->user()?->id) {
            return FeedLastVisitedRooms::query()->where('user_id', $request->user()->id)->get()->map(function ($last) {
                return $last->room;
            });
        }

        return FeedLastVisitedRooms::query()->where('uuid', $request->validated()['identify'])->get()->map(function ($last) {
            return $last->room;
        });
    }

    public function store(LastVisitedStoreRequest $request)
    {
        $data = $request->validated();

        FeedLastVisitedRooms::query()->updateOrCreate([
            'uuid' => $data['identify'],
            'user_id' => $request->user() ? $request->user()?->id : null,
            'feed_room_id' => $data['room_id'],
        ]);
    }
}
