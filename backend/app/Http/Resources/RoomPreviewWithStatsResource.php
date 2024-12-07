<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomPreviewWithStatsResource extends RoomPreviewResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'points' => $this->points
        ]);
    }
}
