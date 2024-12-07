<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\HasMany;

class FeedRooms extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $collection = 'feed_rooms';

    protected $fillable = [
        'username',
        'chat',
        'viewers',
        'status',
        'preview_image',
        'embed_url',
        'chat_url',
        'gender',
        'new',
        'hd',
        'dmca',
        'subject',
        'age',
        'height',
        'weight',
        'location',
        'ethnicity',
        'body_type',
        'bust_penis_size',
        'language',
        'secondary_language',
        'hair_color',
        'hair_length',
        'sex_orientation',
        'pubic_hair',
        'eye_color',
        'tags',
        'flag',
        'unique_identifier',
        'sort_order',
        'first_online',
        'last_online',
        'likes',
        'followers',
        'view_diff',
    ];

//    protected $appends = ['first_seen', 'last_seen', 'avg_viewers', 'max_viewers'];


    protected static function boot()
    {
        static::creating(function($model) {
            $model->first_online = now();
        });

        parent::boot(); // TODO: Change the autogenerated stub
    }

    public function onlineTimes(): HasMany

    {
        return $this->hasMany(FeedRoomOnlineTimes::class, 'feed_room_id');
    }

    public function online_times(): HasMany
    {
        return $this->hasMany(FeedRoomOnlineTimes::class, 'feed_room_id');
    }

    public function viewers_records()
    {
        return $this->hasMany(FeedRoomViewerRecord::class, 'feed_room_id');
    }

    public function getFirstSeenAttribute()
    {
        return $this->onlineTimes()->value('login_time');
    }

    public function getLastSeenAttribute()
    {
        return $this->onlineTimes()->latest('login_time')->value('login_time');
    }

    public function getAvgViewersAttribute()
    {
        return floor($this->viewers_records()->get()->avg('avg_viewers'));
    }

    public function getMaxViewersAttribute()
    {
        return $this->viewers_records()->get()->max('max_viewers');
    }
}