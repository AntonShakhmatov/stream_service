<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Models\FeedLikedRoom;
use App\Models\FeedRooms;
use App\Models\LikedRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LikedRoomController extends Controller
{
    public function index(Request $request)
    {
        return RoomPreviewResource::collection($request->user()->liked_rooms->load('room')->pluck('room'));
    }

    // User's liked rooms are attached to the UserResource
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', Rule::exists('feed_rooms', 'id')]
        ]);

        // If the room is already liked, then room will be unliked
        if ($liked_room = FeedLikedRoom::query()->where(['user_id' => $request->user()->id, 'feed_room_id' => $request->room_id])->first()) {
            $liked_room->delete();

            $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();
            $feedRoom->update(['likes' => --$feedRoom->likes]);

            return response(null, Response::HTTP_ACCEPTED);
        } else {
            $request->user()->liked_rooms()->create([
                'feed_room_id' => $request->room_id
            ]);

            $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();
            $feedRoom->update(['likes' => ++$feedRoom->likes]);
        }

        return response(null, Response::HTTP_CREATED);
    }
}
