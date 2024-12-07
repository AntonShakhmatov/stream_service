<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::whereNotNull('name')->delete();
        Chat::create(['id' => 1,'name'=> 'chaturbate', 'feed_url'=> config("parser.chaturbate")]);
        Chat::create(['id' => 2,'name'=> 'myfreecams', 'feed_url'=> config("parser.myfreecams")]);
        Chat::create(['id' => 3,'name'=> 'bongacams', 'feed_url'=> config("parser.bongacams")]);
        Chat::create(['id' => 4,'name'=> 'camsoda', 'feed_url'=>config("parser.camsoda")]);
        Chat::create(['id' => 5,'name'=> 'cam4', 'feed_url'=> config("parser.cam4")]);
        Chat::create(['id' => 6,'name'=> 'stripchat', 'feed_url'=> config("parser.stripchat")]);
    }
}
