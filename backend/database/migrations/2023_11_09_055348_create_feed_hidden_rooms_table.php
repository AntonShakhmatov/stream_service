<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mongodb')->table('feed_hidden_rooms', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('feed_room_id');

            $collection->timestamps();

            $collection->unique(['user_id' => 1, 'feed_room_id' => 1]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_hidden_rooms');
    }
};
