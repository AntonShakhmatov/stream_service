<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\AffiliateLinkController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\MissMFCStatsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteModelsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect()->route('login'));
// Route::get('/', [HomePageController::class, 'index']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('store');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('destroy');

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/country', [CountryController::class, 'index'])->name('country.index');

    Route::resource('/room', RoomsController::class)->names('room');

    // Route::resource('/aff', AffiliateLinkController::class)->names('aff');
    // Route::get('/aff', [AffiliateLinkController::class, 'index']);
    // Route::post('/aff', [AffiliateLinkController::class, 'store']);
    // Route::delete('/aff/{id}', [AffiliateLinkController::class, 'destroy']);


    Route::prefix('aff')->group(function () {
        Route::get('/', [AffiliateLinkController::class, 'index'])->name('aff.index');
        Route::delete('/{affiliateLink}', [AffiliateLinkController::class, 'destroy'])->name('aff.destroy');
        Route::get('/create', [AffiliateLinkController::class, 'create'])->name('aff.create');
        Route::post('/store', [AffiliateLinkController::class, 'store'])->name('aff.store');
        Route::put('/{affiliateLink}', [AffiliateLinkController::class, 'update'])->name('aff.update');
    });

    Route::prefix('favorite')->group(function () {
        Route::get('/', [FavoriteModelsController::class, 'index'])->name('favorite.index');
        Route::post('/store', [FavoriteModelsController::class, 'store'])->name('favorite.store');
        Route::put('/update/{id}', [FavoriteModelsController::class, 'update'])->name('favorite.update');
    });

    // Route::get('/miss-mfc-stats', [MissMFCStatsController::class, 'index'])->name('mfcstats-miss.index');
    // Route::get('/miss-mfc-stats/create', [MissMFCStatsController::class, 'create'])->name('mfcstats-miss.create');
    // Route::post('/miss-mfc-stats', [MissMFCStatsController::class, 'store'])->name('mfcstats-miss.store');
    // Route::delete('/miss-mfc-stats', [MissMFCStatsController::class, 'destroy'])->name('mfcstats-miss.destroy');
    // Route::get('/miss-mfc-stats/{date}/archive', [MissMFCStatsController::class, 'archive'])->name('mfcstats-miss.archive');

    // Route::get('unassigned-locations', [CountryController::class, 'unassignedLocations'])->name('country.unassigned-locations');
    // Route::post('umassigned-locations/assing', [CountryController::class, 'assignUnassigned'])->name('country.assing-unassigned');

    Route::resource('users', UsersController::class)->names('users');
});
