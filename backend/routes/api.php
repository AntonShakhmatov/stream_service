<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HiddenRoomController;
use App\Http\Controllers\LikedRoomController;
use App\Http\Controllers\OnlineTimeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomNoteController;
use App\Http\Controllers\RoomPhotoController;
use App\Http\Controllers\RoomStatsController;
use App\Http\Controllers\RoomTagController;
use App\Http\Controllers\SavedRoomController;
use App\Http\Controllers\stats\ChaturbateMostFollowedController;
use App\Http\Controllers\stats\ChaturbateMostPopularController;
use App\Http\Controllers\stats\MissMFCController;
use App\Http\Controllers\stats\MyfreecamsBestScoreController;
use App\Http\Controllers\TopRatedRoomController;
use App\Http\Controllers\TrendingRoomController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\AffiliateLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

// Route::get('/admin', [AdminController::class]);

// Route::prefix('admin')->group(function () {
// Route::resource('affiliate-links', App\Http\Controllers\Admin\AffiliateLinkController::class)->except(['create', 'edit']);
// Route::get('/aff', [AffiliateLinkController::class, 'index']);
// Route::post('/aff', [AffiliateLinkController::class, 'store']);
// Route::delete('/aff/{id}', [AffiliateLinkController::class, 'destroy']);
// });


// Route::prefix('aff')->group(function () {
//     Route::get('/', [AffiliateLinkController::class, 'index'])->name('aff.index');
//     Route::get('/create', [AffiliateLinkController::class, 'create'])->name('aff.create');
//     Route::post('/', [AffiliateLinkController::class, 'store'])->name('aff.store');
// });

Route::get('/rooms/wp-api', [RoomController::class, 'wp_api']);

Route::resource('/rooms', RoomController::class);
Route::get('/room-tags', [RoomTagController::class, 'index']);

Route::get('/api/rooms/{id}', [RoomController::class, 'getProfileRoom']);

Route::get('/rooms/{room}/stats', RoomStatsController::class);
Route::get('/rooms/{room}/online-times', OnlineTimeController::class);

Route::get('/room-photos/{room}', [RoomPhotoController::class, 'index']);

Route::resource('/top-rated-rooms', TopRatedRoomController::class);
Route::get('/trending-rooms', TrendingRoomController::class);

Route::get('/stats/chaturbate-most-followed', ChaturbateMostFollowedController::class);
Route::get('/stats/chaturbate-most-popular', ChaturbateMostPopularController::class);
Route::get('/stats/myfreecams-best-score', MyfreecamsBestScoreController::class);
Route::get('/stats/miss-mfc', MissMFCController::class);

Route::post('/search/tags/{text}', [\App\Http\Controllers\SearchController::class, 'tags']);
Route::post('/search/topics/{text}', [\App\Http\Controllers\SearchController::class, 'topics']);
Route::post('/search/username/{text}', [\App\Http\Controllers\SearchController::class, 'username']);

Route::get('redis-set-top-rated', [\App\Http\Controllers\RedisController::class, 'setTopRated']);
Route::get('redis-set-trending-rooms', [\App\Http\Controllers\RedisController::class, 'setTrending']);
Route::get('redis-set-rooms', [\App\Http\Controllers\RedisController::class, 'setRooms']);
Route::get('render-tags', [\App\Http\Controllers\RedisController::class, 'renderTags']);

Route::get('parser/parse-all-feeds', [\App\Http\Controllers\Parsers\FullParseController::class, '__invoke']);

// Route::get('/clients', [AdminController::class, 'index']);

Route::resource('last-visited-rooms', \App\Http\Controllers\LastVisitedController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/liked-rooms', LikedRoomController::class);

    Route::resource('/saved-rooms', SavedRoomController::class);

    Route::resource('/hidden-rooms', HiddenRoomController::class);

    Route::resource('/room-notes', RoomNoteController::class);
});

require __DIR__ . '/auth.php';
