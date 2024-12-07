<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

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
        'sort_order'
        ];

    protected $appends = ['likes', 'saves', 'first_seen', 'last_seen', 'avg_viewers', 'max_viewers'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function getLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function getSavesAttribute()
    {
        return $this->saves()->count();
    }

    public function getCountAllRoomsAttribute(): int
    {
        return $this->newQuery()->count('id');
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

    public function onlineTimes()
    {
        return $this->hasMany(OnlineTime::class, 'room_id');
    }

    public function likes()
    {
        return $this->hasMany(LikedRoom::class);
    }

    public function saves()
    {
        return $this->hasMany(SavedRoom::class);
    }

    public function viewers_records()
    {
        return $this->hasMany(ViewersRecord::class);
    }

    public function online_times()
    {
        return $this->hasMany(OnlineTime::class);
    }

    public function photos()
    {
        return $this->hasMany(RoomPhoto::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
