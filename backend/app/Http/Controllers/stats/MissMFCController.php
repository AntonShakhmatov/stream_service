<?php

namespace App\Http\Controllers\stats;

use App\Http\Controllers\Controller;
use App\Models\MissMFCStats;
use App\Models\Room;

class MissMFCController extends Controller
{
    public function __invoke()
    {
        return Room::query()
            ->join('miss_m_f_c_stats as miss', 'rooms.mfc_id', '=', 'miss.mfc_id')
            ->select(['rooms.id', 'username', 'chat', 'viewers', 'status', 'preview_image', 'chat_url', 'gender',
                'location','new', 'hd', 'age', 'rooms.created_at', 'rooms.updated_at','miss.rank as mfc_rank','mfc_score',
                'cb_followers','cb_score', 'flag','sort_order','subject', 'cb_score as points'])
            ->where(['chat' => 'myfreecams'])
            ->whereNull('archived_at')
            ->orderBy('miss.rank')
            ->take(1000)
            ->paginate($request->perPage ?? 100);
    }
}
