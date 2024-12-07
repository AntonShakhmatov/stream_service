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
    // public function index(Request $request)
    // {
    //     return RoomPreviewResource::collection($request->user()->liked_rooms->load('room')->pluck('room'));
    // }

    public function index(Request $request)
    {
        $likedRooms = $request->user()->liked_rooms()->with('room')->get()->pluck('room');

        return RoomPreviewResource::collection($likedRooms);
    }

    // User's liked rooms are attached to the UserResource
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'room_id' => ['required', Rule::exists('feed_rooms', 'id')]
    //     ]);

    //     // If the room is already liked, then room will be unliked
    //     if ($liked_room = FeedLikedRoom::query()->where(['user_id' => $request->user()->id, 'feed_room_id' => $request->room_id])->first()) {
    //         $liked_room->delete();

    //         $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();
    //         $feedRoom->update(['likes' => --$feedRoom->likes]);

    //         return response(null, Response::HTTP_ACCEPTED);
    //     } else {
    //         $request->user()->liked_rooms()->create([
    //             'feed_room_id' => $request->room_id
    //         ]);

    //         $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();
    //         $feedRoom->update(['likes' => ++$feedRoom->likes]);
    //     }

    //     return response(null, Response::HTTP_CREATED);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required']
        ]);

        // Проверка на наличие `room_id` в MongoDB
        $roomExists = FeedRooms::where('_id', $request->room_id)->exists();

        if (!$roomExists) {
            return response()->json(['error' => 'Room does not exist'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Если комната уже добавлена в избранное, удаляем её (анлайк)
        $liked_room = FeedLikedRoom::where([
            'user_id' => $request->user()->_id, // Убедитесь, что поле `_id` используется для MongoDB
            'feed_room_id' => $request->room_id
        ])->first();

        if ($liked_room) {
            $liked_room->delete();

            FeedRooms::where('_id', $request->room_id)->decrement('likes');

            return response(null, Response::HTTP_ACCEPTED);
        } else {
            // Добавляем комнату в избранное
            $request->user()->liked_rooms()->create([
                'feed_room_id' => $request->room_id
            ]);

            FeedRooms::where('_id', $request->room_id)->increment('likes');
        }

        return response(null, Response::HTTP_CREATED);
    }
}
