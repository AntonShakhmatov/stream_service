<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTagController extends Controller
{
    public function index()
    {
        // File tags.json is rendered automatically every minute -> check app/Console/Kernel.php
        $tags = json_decode(Storage::get('tags.json'));

        return response()->json($tags);
    }
}
