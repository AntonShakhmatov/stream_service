<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,

            // 'liked_rooms' => $this->liked_rooms->map(fn ($room) => $room->room->toArray()),
            'liked_rooms' => $this->liked_rooms ? $this->liked_rooms->map(function ($room) {
                return $room->room ? $room->room->toArray() : null; // Проверка наличия `room`
            })->filter()->values() : [],

            // 'followed_rooms' => $this->saved_rooms->map(fn($room) => $room->room->toArray()),
            'followed_rooms' => $this->saved_rooms ? $this->saved_rooms->map(function ($room) {
                return $room->room ? $room->room->toArray() : null;
            })->filter()->values() : [],

            // 'hidden_rooms' => $this->hidden_rooms->map(fn($room) => $room->room->toArray()),
            'hidden_rooms' => $this->hidden_rooms ? $this->hidden_rooms->map(function ($room) {
                return $room->room ? $room->room->toArray() : null;
            })->filter()->values() : [],

            // 'notes' => $this->room_notes->map(fn($room) => ['note' => $room, 'room' => $room->room]),
            'notes' => $this->room_notes ? $this->room_notes->map(function ($room) {
                return $room->room ? $room->room->toArray() : null;
            })->filter()->values() : [],
        ];
    }
}
