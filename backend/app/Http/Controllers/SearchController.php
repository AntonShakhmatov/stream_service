<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRoomTagsRequest;
use App\Http\Requests\SearchRoomTopicsRequest;
use App\Http\Requests\SearchRoomUsernameRequest;
use App\Models\Chat;
use App\Models\FeedRooms;
use App\Models\Room;

class SearchController extends Controller
{
    public function tags(SearchRoomTagsRequest $request, $text): mixed
    {

        $tags = FeedRooms::query()->whereIn('tags', [$text]);
        $tags = $this->getAdditionalQuery($request->validated(), $tags);
        return $tags->orderBy('sort_order')->paginate(10);

    }

    public function topics(SearchRoomTopicsRequest $request, $text)
    {
        $topics = FeedRooms::query()->where('subject', 'like', "%$text%");
        $topics = $this->getAdditionalQuery($request->validated(), $topics);

        return $topics->orderBy('sort_order')->paginate(10);
    }

    public function username(SearchRoomUsernameRequest $request, $text)
    {
        $username = FeedRooms::query()->where('username', 'like', "%$text%");
        $username = $this->getAdditionalQuery($request->validated(), $username);

        return $username->orderBy('sort_order')->paginate(10);
    }

    protected function getAdditionalQuery($validated, $query): mixed
    {
        if ($validated['offline'] === "false") {
            $query = $query->where('status', '!=', 0);
        }
        $query = $query->where(function () use ($validated, &$query) {
            $chats = Chat::query()->pluck('id', 'name')->toArray();
            if ($validated['rooms'][0]['chaturbate']) {
                $query = $query->orWhere('chat', '=', $chats['chaturbate']);
            }
            if ($validated['rooms'][0]['bongacams']) {
                $query = $query->orWhere('chat', '=', $chats['bongacams']);
            }
            if ($validated['rooms'][0]['myfreecams']) {
                $query = $query->orWhere('chat', '=', $chats['myfreecams']);
            }
            if ($validated['rooms'][0]['camsoda']) {
                $query = $query->orWhere('chat', '=', $chats['camsoda']);
            }
            if ($validated['rooms'][0]['cam4']) {
                $query = $query->orWhere('chat', '=', $chats['cam4']);
            }
        });

        return $query;
    }
}
