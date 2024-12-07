<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Room;
use Illuminate\Console\Command;

class RenderLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render-room-locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        set_time_limit(0);
        Room::query()->where('status', '!=', 'offline')
            ->leftJoin('country_aliases', 'country_aliases.name', 'like', "%location%")
            ->join('countries', 'countries.id', '=', 'country_aliases.country_id')
            ->select([
                'rooms.id', 'countries.flag  as country_flag'
            ])->get()->unique('id')->map(function ($room) {
                $room->update(['flag' => $room->country_flag]);
            });
        $this->info('flaged rooms '.Room::query()->whereNotNull('flag')->count());

        $this->info("flags generated");
        return 1;
    }
}
