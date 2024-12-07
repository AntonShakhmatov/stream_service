<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignUnassignedRequest;
use App\Models\Country;
use App\Models\CountryAlias;
use App\Models\FeedRooms;
use App\Models\Room;
use App\Queries\FuzzyFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countryQuery = QueryBuilder::for(Country::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id',
                    'name',
                    'flag'
                )),
            ])
            ->allowedSorts(['id', 'name', 'flag'])
            ->defaultSort('id');

        $countries = $countryQuery
            ->select(['id', 'name', 'flag'])
            ->paginate($request->perPage ?? 25)
            ->withQueryString();

        return Inertia::render('Countries/Index', [
            'countries' => $countries,
        ]);
    }

    public function unassignedLocations(Request $request)
    {
        $unassigned = QueryBuilder::for(FeedRooms::class)
            ->allowedFilters([
                'search' => AllowedFilter::custom('search', new FuzzyFilter(
                    'location'
                ))
            ])
            ->allowedSorts('id', 'location')
            ->defaultSort('id')
            ->whereNull('flag')
            ->select(['location', 'id'])
            ->groupBy(['location', 'id'])
            ->paginate($request->perPage ?? 25)
            ->withQueryString();

        $country = Country::query()->pluck('name', 'id');

        return Inertia::render('Countries/Unassigned', [
            'unassigned' => $unassigned,
            'countries' => $country,
        ]);
    }



    public function assignUnassigned(AssignUnassignedRequest $request)
    {
        $data = $request->validated();
        $country = Country::find($data['country_id']);
        FeedRooms::query()->whereIn('id', $data['selectedItems'])->select('location')->get()->each(function ($room) use ($data, $country) {
            CountryAlias::query()->insert([
                'name' => $room->location,
                'country_id' => $data['country_id'],
            ]);
            $room->update(['flag' => $country->flag]);
        });

        return back()->with(['message' => 'Assigned location and re-rendered locations']);
    }

    private function setAndReturnCountry(): array
    {
        $country = Country::pluck('flag', 'name')->toArray();
        Redis::lpush('country', serialize(json_encode($country)));

        return $country;
    }
}
