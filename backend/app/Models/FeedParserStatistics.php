<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class FeedParserStatistics extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'feed_parser_statistics';

    public $timestamps = false;

    protected $fillable = ['status', 'feeds', 'start_parse', 'end_parse', 'parse_time'];

}
