<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Models\FeedFollowersRoom;
use App\Models\FeedRooms;
use App\Models\SavedRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SavedRoomController extends Controller
{
    public function index(Request $request)
    {
        return RoomPreviewResource::collection($request->user()->saved_rooms->load('room')->pluck('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', Rule::exists('feed_rooms', 'id')]
        ]);

        $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();

        // If the room is already saved, then room will be unsaved
        if ($saved_room = FeedFollowersRoom::query()->where(['user_id' => $request->user()->id, 'feed_room_id' => $request->room_id])->first()) {
            $saved_room->delete();

            $feedRoom->update(['followers' => --$feedRoom->followers]);

            return response(null, Response::HTTP_ACCEPTED);
        } else {
            $request->user()->saved_rooms()->create([
                'feed_room_id' => $request->room_id
            ]);

            $feedRoom->update(['followers' => ++$feedRoom->followers]);
        }

        return response(null, Response::HTTP_CREATED);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'room_id' => 'required', 'exists:saved_rooms,room_id',
        ]);

        SavedRoom::query()->where(['user_id' => $request->user()->id, 'room_id' => $request->room_id])->first()?->delete();
        return response()->status(Response::HTTP_ACCEPTED);
    }
}
