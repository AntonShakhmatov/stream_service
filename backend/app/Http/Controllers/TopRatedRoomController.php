<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomPreviewResource;
use App\Models\FeedRooms;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\TopRatedRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;


class TopRatedRoomController extends Controller
{
    public function index()
    {
        // Получаем список имён из таблицы favorite_models
        $favoriteModels = DB::table('favorite_models')->pluck('username');

        // Фильтруем комнаты по именам из списка
        $topRatedRooms = FeedRooms::query()
            ->whereIn('username', $favoriteModels)
            ->where('status', 0)
            ->orderBy('sort_order')
            ->get();

        return $topRatedRooms;
    }
}
