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
    // public function index(Request $request)
    // {
    //     return RoomPreviewResource::collection($request->user()->saved_rooms->load('room')->pluck('room'));
    // }

    public function index(Request $request)
    {
        // Загружаем комнаты, сохраненные пользователем
        $savedRooms = $request->user()->saved_rooms()->with('room')->get()->pluck('room');
        return RoomPreviewResource::collection($savedRooms);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'room_id' => ['required', Rule::exists('feed_rooms', 'id')]
    //     ]);

    //     $feedRoom = FeedRooms::query()->whereId($request->room_id)->first();

    //     // If the room is already saved, then room will be unsaved
    //     if ($saved_room = FeedFollowersRoom::query()->where(['user_id' => $request->user()->id, 'feed_room_id' => $request->room_id])->first()) {
    //         $saved_room->delete();

    //         $feedRoom->update(['followers' => --$feedRoom->followers]);

    //         return response(null, Response::HTTP_ACCEPTED);
    //     } else {
    //         $request->user()->saved_rooms()->create([
    //             'feed_room_id' => $request->room_id
    //         ]);

    //         $feedRoom->update(['followers' => ++$feedRoom->followers]);
    //     }

    //     return response(null, Response::HTTP_CREATED);
    // }


    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required']
        ]);

        // Проверка наличия комнаты в базе данных MongoDB
        $feedRoom = FeedRooms::where('_id', $request->room_id)->first();
        if (!$feedRoom) {
            return response()->json(['error' => 'Room does not exist'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Проверка: если комната уже сохранена, удалим её
        $savedRoom = FeedFollowersRoom::where([
            'user_id' => $request->user()->_id,
            'feed_room_id' => $request->room_id
        ])->first();

        if ($savedRoom) {
            $savedRoom->delete();

            // Уменьшаем счетчик подписчиков
            $feedRoom->decrement('followers');

            return response(null, Response::HTTP_ACCEPTED);
        } else {
            // Сохранение комнаты для пользователя
            $request->user()->saved_rooms()->create([
                'feed_room_id' => $request->room_id
            ]);

            // Увеличение счетчика подписчиков
            $feedRoom->increment('followers');
        }

        return response(null, Response::HTTP_CREATED);
    }

    // public function destroy(Request $request)
    // {
    //     $request->validate([
    //         'room_id' => 'required', 'exists:saved_rooms,room_id',
    //     ]);

    //     SavedRoom::query()->where(['user_id' => $request->user()->id, 'room_id' => $request->room_id])->first()?->delete();
    //     return response()->status(Response::HTTP_ACCEPTED);
    // }


    public function destroy(Request $request)
    {
        $request->validate([
            'room_id' => 'required'
        ]);

        // Удаление комнаты из сохраненных
        SavedRoom::where([
            'user_id' => $request->user()->_id,
            'feed_room_id' => $request->room_id
        ])->first()?->delete();

        return response(null, Response::HTTP_ACCEPTED);
    }
}
