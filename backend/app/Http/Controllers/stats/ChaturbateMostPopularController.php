<?php

namespace App\Http\Controllers\stats;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomPreviewWithStatsResource;
use App\Models\Room;
use Illuminate\Http\Request;

class ChaturbateMostPopularController extends Controller
{
    public function __invoke(Request $request)
    {
        return Room::query()
            ->select(['id', 'username', 'chat', 'viewers', 'status', 'preview_image', 'chat_url', 'gender',
                'location','new', 'hd', 'age', 'created_at', 'updated_at','mfc_rank','mfc_score',
                'cb_followers','cb_score', 'flag','sort_order','subject', 'cb_score as points'])
            ->where(['chat' => 'chaturbate'])
            ->when($request->genders, function ($q, $gender) {
                $q->where(['gender' => $gender]);
            })
            ->orderBy('points', 'DESC')
            ->take(1000)
            ->paginate($request->perPage ?? 100);

    }
}
