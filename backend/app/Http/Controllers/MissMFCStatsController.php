<?php

namespace App\Http\Controllers;

use App\Http\Requests\MissMfcDestroyRequest;
use App\Http\Requests\MissMfcStoreRequest;
use App\Models\MissMFCStats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MissMFCStatsController extends Controller
{
    public function index(Request $request)
    {
        $stats = MissMFCStats::query()->groupBy('upload_date')->pluck('upload_date')->map(function ($stats) {
            $data = MissMFCStats::query()->where('upload_date', $stats)->first();
            return [
                'date_formated' => Carbon::parse($stats)->format('F Y'),
                'date' => $stats,
                'archived_at' => is_null($data->archived_at) ? 'Not archived' : 'Archived',
                'created_at' => Carbon::parse($data->created_at)->format('d.m.Y H:i'),
                'updated_at' => Carbon::parse($data->updated_at)->format('d.m.Y H:i'),
            ];
        });

        return Inertia::render('MissMFC/Index', [
            'missMfc' => $stats,
        ]);
    }

    public function create()
    {
        return Inertia::render('MissMFC/Form');
    }

    public function store(MissMfcStoreRequest $request)
    {
        $file = $request->file('miss_mfc');
        collect(json_decode(file_get_contents($file->getRealPath())))->each(fn ($item) =>
            MissMFCStats::create([
                'mfc_id' => $item->id,
                'name' => $item->name,
                'rank' => str_replace('#', '', $item->rank),
                'upload_date' => $request->get('date'),
            ])
        );

        MissMFCStats::query()->whereNot('upload_date', $request->get('date'))->update(['archived_at' => now()]);

        return redirect()->route('mfcstats-miss.index');
    }

    public function archive($date)
    {
        $mfiStats = MissMFCStats::query()->where('upload_date', $date);
        $mfiStats->value('archived_at') !== null ? $mfiStats->update(['archived_at' => null]) : $mfiStats->update(['archived_at' => now()]);

        return back();
    }

    public function destroy(MissMfcDestroyRequest $request)
    {
        $data = $request->validated();
        MissMFCStats::query()->where('upload_date', $data['date'])->delete();

        return redirect()->back();
    }
}
