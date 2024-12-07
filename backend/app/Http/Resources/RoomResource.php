<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'embedUrl' => $this->embed_url,
            'chatUrl' => $this->chat_url,
            'gender' => $this->gender,
            'new' => $this->new,
            'hd' => $this->hd,
            'subject' => $this->subject,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'location' => $this->location,
            'ethnicity' => $this->ethnicity,
            'bodyType' => $this->body_type,
            'bustPenisSize' => $this->bust_penis_size,
            'language' => $this->language,
            'secondaryLanguage' => $this->secondary_language,
            'hairColor' => $this->hair_color,
            'hairLength' => $this->hair_length,
            'sexOrientation' => $this->sex_orientation,
            'pubicHair' => $this->pubic_hair,
            'eyeColor' => $this->eye_color,
            'cbFollowers' => $this->cb_followers,
            'cbScore' => $this->cb_score,
            'mfcRank' => $this->mfc_rank,
            'mfcScore' => $this->mfc_score,
            'tags' => $this->tags,
            'firstSeen' => Carbon::parse($this->created_at)->format('M jS, Y'),
            'lastSeen' => Carbon::parse($this->updated_at)->format('M jS, Y'),
            'likes' => $this->likes,
            'saves' => $this->saves
        ];
    }
}
