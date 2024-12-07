<?php

namespace App\Console\Commands;

use App\Models\FeedRoomOnlineTimes;
use App\Models\FeedRooms;
use App\Models\FeedRoomViewerRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveDataPgsqlToMongoDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move-data-pgsql-to-mongodb {--rooms} {--online} {--records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('rooms')) {
            foreach (array_chunk(DB::connection('pgsql')->table('feed_rooms')->get()->toArray(), 1000) as $chunk) {
                foreach ((array)$chunk as $data) {
                    FeedRooms::insert((array)$data);
                }
            }

            echo "Done move rooms";
        }

        if ($this->option('online')) {
            $max = 1000;
            $total = DB::connection('pgsql')->table('feed_room_online_times')->count();
            $pages = ceil($total / $max);
            $bar = $this->output->createProgressBar($total);
            $bar->start();

            for ($i = 1; $i < ($pages + 1); $i++) {
                $offset = (($i - 1)  * $max);
                $start = ($offset == 0 ? 0 : ($offset + 1));
                $legacy = DB::connection('pgsql')->table("feed_room_online_times")->skip($start)->take($max)->get()->toArray();

                foreach($legacy as $item) {
                    FeedRoomOnlineTimes::insert((array)$item);
                    $bar->advance();
                }
            }
            $bar->finish();

            echo "Done move online times";
        }

        if ($this->option('records')) {
            $max = 1000;
            $total = DB::connection('pgsql')->table('feed_room_viewer_records')->count();
            $pages = ceil($total / $max);
            $bar = $this->output->createProgressBar($total);
            $bar->start();

            for ($i = 1; $i < ($pages + 1); $i++) {
                $offset = (($i - 1)  * $max);
                $start = ($offset == 0 ? 0 : ($offset + 1));
                $legacy = DB::connection('pgsql')->table("feed_room_viewer_records")->skip($start)->take($max)->get()->toArray();

                foreach($legacy as $item) {
                    FeedRoomViewerRecord::insert((array)$item);
                    $bar->advance();
                }
            }

            echo "Done move viewer records";
        }

    }
}
