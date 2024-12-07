<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mongodb')->table('feed_room_online_times', function (Blueprint $collection) {
            $collection->index('feed_room_id');
            $collection->index('status');
            $collection->index('login_time');
            $collection->index('logout_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_room_online_times');
    }
};
