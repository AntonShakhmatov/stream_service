<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomPreviewResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'chat' => $this->chat,
            'viewers' => $this->viewers,
            'status' => $this->status,
            'previewImage' => $this->preview_image,
            'chatUrl' => $this->chat_url,
            'gender' => $this->gender,
            'location' => $this->location,
            'new' => $this->new,
            'hd' => $this->hd,
            'age' => $this->age,
        ];
    }
}
