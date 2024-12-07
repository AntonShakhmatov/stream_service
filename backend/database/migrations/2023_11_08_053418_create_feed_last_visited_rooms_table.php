<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mongodb')->table('feed_last_visited_rooms', function (Blueprint $collection) {
            $collection->index('uuid');
            $collection->index('feed_room_id');
            $collection->index('user_id');

            $collection->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_last_visited_rooms');
    }
};
