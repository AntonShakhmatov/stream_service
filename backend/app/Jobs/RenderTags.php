<?php

namespace App\Jobs;

use App\Models\FeedRooms;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RenderTags implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tags_arrays =  FeedRooms::query()->where("status", '!=', 0)->pluck("tags")->toArray();

        $tags = array();

        foreach ($tags_arrays as $tags_array) {
            $tags = is_array($tags_array) ? array_merge($tags, $tags_array) : array_merge($tags, str_replace(['[',']', '"'], '', explode(",",$tags_array)));
        }

        $tags = array_count_values($tags);

        $final_form = array();

        foreach ($tags as $tag => $rooms_count) {
            $final_form[] = [
                "name" => (string)$tag,
                "count" => $rooms_count
            ];
        }

        Storage::disk('local')->put('tags.json', json_encode($final_form));
    }
}
