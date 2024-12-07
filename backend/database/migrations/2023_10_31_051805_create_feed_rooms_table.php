<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->table('feed_rooms', function (Blueprint $collection) {
            $collection->index('username');
            $collection->index('chat');
            $collection->index('status');
            $collection->index('viewers');
            $collection->index('gender');
            $collection->index('new');
            $collection->index('hd');
            $collection->index('age');
            $collection->index('height');
            $collection->index('weight');
            $collection->index('location');
            $collection->index('ethnicity');
            $collection->index('body_type');
            $collection->index('bust_penis_size');
            $collection->index('language');
            $collection->index('secondary_language');
            $collection->index('hair_color');
            $collection->index('hair_length');
            $collection->index('sex_orientation');
            $collection->index('pubic_hair');
            $collection->index('eye_color');
            $collection->index('likes');
            $collection->index('followers');
            $collection->index('old_viewers');


            // Vytvorenie zložených indexov
            $collection->unique(['username' => 1, 'chat' => 1, 'unique_identifier' => 1]);

            // Ak chcete vytvoriť unikátne indexy, môžete použiť:
            $collection->unique('unique_identifier');

            // Soft deletes (využíva pole deleted_at)
            $collection->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->table('feed_rooms', function (Blueprint $collection)
        {
            $collection->drop();
        });
    }
};
