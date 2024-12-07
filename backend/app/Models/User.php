<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function saved_rooms()
    {
        // return $this->hasMany(FeedFollowersRoom::class);
        return $this->hasMany(FeedFollowersRoom::class, 'user_id', 'id');
    }

    public function liked_rooms()
    {
        // return $this->hasMany(FeedLikedRoom::class);
        return $this->hasMany(FeedLikedRoom::class, 'user_id', 'id');
    }

    public function hidden_rooms()
    {
        // return $this->hasMany(FeedHiddenRooms::class);
        return $this->hasMany(FeedHiddenRooms::class, 'user_id', 'id');
    }

    public function room_notes()
    {
        // return $this->hasMany(FeedRoomNote::class);
        return $this->hasMany(FeedRoomNote::class, 'user_id', 'id');
    }
}
