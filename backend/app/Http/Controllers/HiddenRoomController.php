<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Models\HiddenRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class HiddenRoomController extends Controller
{
    public function index(Request $request)
    {
        return RoomPreviewResource::collection($request->user()->hidden_rooms->load('room')->pluck('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', Rule::exists('rooms', 'id')]
        ]);

        // If the room is already hidden, then room will be unhidden
        if ($hidden_room = HiddenRoom::query()->where(['user_id' => $request->user()->id, 'room_id' => $request->room_id])->first()) {
            $hidden_room->delete();
            return response(null, Response::HTTP_ACCEPTED);
        } else {
            $request->user()->hidden_rooms()->create([
                'room_id' => $request->room_id
            ]);
        }

        return response(null, Response::HTTP_CREATED);
    }
}
