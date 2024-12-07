<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomNoteResource;
use App\Models\FeedRoomNote;
use App\Models\RoomNote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RoomNoteController extends Controller
{
    public function index(Request $request)
    {
        return RoomNoteResource::collection(
            $request->user()->room_notes()
            ->orderBy('updated_at', 'DESC')
            ->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', Rule::exists('feed_rooms', 'id')],
            'note' => ['nullable', 'string'],
        ]);

        $room_note = FeedRoomNote::query()->updateOrCreate([
            'user_id' => $request->user()->id,
            'feed_room_id' => $request->room_id
        ], [
            'note' => $request->note
        ]);

        return new RoomNoteResource($room_note);
    }

    public function show(Request $request, FeedRoomNote $room_note)
    {
        if ($request->user()->id != $room_note->user_id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return new RoomNoteResource($room_note);
    }

    public function destroy(Request $request, FeedRoomNote $room_note)
    {
        if ($request->user()->id != $room_note->user_id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $room_note->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
