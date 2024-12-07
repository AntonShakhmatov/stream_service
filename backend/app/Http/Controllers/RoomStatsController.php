<?php

namespace App\Http\Controllers;

use App\Models\FeedRooms;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomStatsController extends Controller
{
    public function __invoke(FeedRooms $room, Request $request)
    {
        $response = [
            'labels' => [],
            'data' => [
                'max_viewers' => [],
                'avg_viewers' => [],
                1 => [],
                2 => [],
                3 => [],
                4 => [],
                5 => [],
                6 => []
            ]
        ];

        $online_times = $room->online_times()->whereDate('logout_time', '>=', Carbon::today()->subDays($request->days - 1))->get();
        $ongoing_login = $room->online_times()->where('logout_time', null)->first();

        for ($i = 0; $i < $request->days; $i++) {
            $date = Carbon::today()->subDays($i);
            array_push($response['labels'], $date->format('d-m-Y'));

            array_push($response['data'][1], 0);
            array_push($response['data'][2], 0);
            array_push($response['data'][3], 0);
            array_push($response['data'][4], 0);
            array_push($response['data'][5], 0);
            array_push($response['data'][6], 0);

            if ($ongoing_login) {
                $ongoing_login->logout_time = Carbon::now();
                $online_times = collect()->merge($online_times)->merge([$ongoing_login]);
            }

            foreach ($online_times as $online_time) {
                if ($online_time->login_time->gte($date->copy()->addDay()) || $online_time->logout_time->lt($date)) {
                    continue;
                }
                $from = $online_time->login_time->lt($date) ? $date : $online_time->login_time;
                $to = $online_time->logout_time->gte($date->copy()->addDay()) ? $date->copy()->addDay() : $online_time->logout_time;

                $response['data'][str_replace(' ', '_', $online_time->status)][$i] += $to->diffInMinutes($from);
            }

            $viewers = $room->viewers_records()->whereDate('date', $date)->first();
            array_push($response['data']['max_viewers'], isset($viewers->max_viewers) ? $viewers->max_viewers : 0);
            array_push($response['data']['avg_viewers'], isset($viewers->max_viewers) ? $viewers->avg_viewers : 0);
        }

        $response['template'] = $this->template($response['data']);

        return  $response;
    }

    protected function template($data)
    {
        return [
            'online_times' => [
                [
                    'label'=> 'free chat',
                    'borderColor'=> '#34D399',
                    'backgroundColor'=> '#34D399',
                    'fill'=> false,
                    'data'=> $data[1],
                ],
                [
                    'label'=> 'group chat',
                    'borderColor'=> '#F59E0B',
                    'backgroundColor'=> '#F59E0B',
                    'fill'=> false,
                    'data'=> $data[2],
                ],
                [
                    'label'=> 'private chat',
                    'borderColor'=> '#EF4444',
                    'backgroundColor'=> '#EF4444',
                    'fill'=> false,
                    'data'=> $data[3],
                ],
                [
                    'label'=> 'club show',
                    'borderColor'=> '#D97706',
                    'backgroundColor'=> '#D97706',
                    'fill'=> false,
                    'data'=> $data[4],
                ],
                [
                    'label'=> 'away',
                    'borderColor'=> '#6B7280',
                    'backgroundColor'=> '#6B7280',
                    'fill'=> false,
                    'data'=> $data[5],
                ],
                [
                    'label'=> 'true private',
                    'borderColor'=> '#6366F1',
                    'backgroundColor'=> '#6366F1',
                    'fill'=> false,
                    'data'=> $data[6],
                ],
            ],
            'viewers' => [
                [
                    'label' =>  'max viewers',
                    'borderColor' =>  '#ff6384',
                    'backgroundColor' =>  '#ff6384',
                    'data' => $data['max_viewers'],
                ],
                [
                    'label' =>  'avg viewers',
                    'borderColor' =>  '#0077E5',
                    'backgroundColor' =>  '#0077E5',
                    'data' => $data['avg_viewers'],
                ],
            ]
        ];
    }
}
