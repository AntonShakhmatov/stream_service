<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mongodb')->table('feed_room_viewer_records', function (Blueprint $collection) {
            $collection->index('feed_room_id');
            $collection->index('max_viewers');
            $collection->index('avg_viewers');
            $collection->index('num_records');
            $collection->index('date');

            $collection->unique(['feed_room_id' => 1,'date' => 1]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_room_viewer_records');
    }
};
