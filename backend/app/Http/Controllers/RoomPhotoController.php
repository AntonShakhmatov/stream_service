<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPhotoResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomPhotoController extends Controller
{
    public function index(Room $room, Request $request)
    {
        $photos = $room->photos()
            ->orderBy('pinned', 'DESC')
            ->when($request->limit, function ($q, $limit) {
                $q->take($limit);
            })->get();

        return RoomPhotoResource::collection($photos);
    }
}
