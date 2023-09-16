<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/oauth/login', function () {
    return response()->json(['status' => 0, 'message' => 'Unauthorized, please login first'], 200);
})->name('login');

Route::post('/oauth/login', [UserController::class, 'login']);
Route::post('/oauth/register', [UserController::class, 'register']);
Route::post('/oauth/logout', [UserController::class, 'logout']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/accounts', [UserController::class, 'index']);

    Route::post('/animes', [AnimeController::class, 'store']);
    Route::post('/videos', [VideoController::class, 'store']);
    Route::post('/genres', [GenreController::class, 'store']);
    Route::post('/studios', [StudioController::class, 'store']);
    Route::post('/streams', [StreamController::class, 'store']);

    Route::put('/animes', [AnimeController::class, 'edit']);
    Route::put('/videos', [VideoController::class, 'edit']);
    Route::put('/genres', [GenreController::class, 'edit']);
    Route::put('/studios', [StudioController::class, 'edit']);
    Route::put('/streams', [StreamController::class, 'edit']);

    Route::delete('/animes', [AnimeController::class, 'destroy']);
    Route::delete('/videos', [VideoController::class, 'destroy']);
    Route::delete('/genres', [GenreController::class, 'destroy']);
    Route::delete('/studios', [StudioController::class, 'destroy']);
    Route::delete('/streams', [StreamController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/animes', [AnimeController::class, 'index']);
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/genres', [GenreController::class, 'index']);
    Route::get('/studios', [StudioController::class, 'index']);
    Route::get('/streams', [StreamController::class, 'index']);
});
