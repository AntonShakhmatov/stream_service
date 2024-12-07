<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedParserStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->table('feed_parser_statistics', function (Blueprint $collection) {
            $collection->index('status');
            $collection->index('feeds');
            $collection->index('start_parse');
            $collection->index('end_parse');
            $collection->index('parse_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_parser_statistics');
    }
}
