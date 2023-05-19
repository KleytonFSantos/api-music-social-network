<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikesController;

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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout');
        Route::get('/get-user', 'getUser');
    });

    Route::post('/edit-profile', [EditProfileController::class, 'editProfile']);

    Route::controller(SongsController::class)->group(function () {
        Route::get('get-songs/{user_id}', 'index');
        Route::post('add-song', 'store');
        Route::delete('{user_id}/delete-song/{song}', 'destroy');
    });

    Route::controller(VideosController::class)->group(function () {
        Route::get('videos/{user_id}', 'index');
        Route::post('add-youtube-video/{user_id}', 'store');
        Route::delete('{user_id}/delete-youtube-videos/{video}', 'destroy');
    });

    Route::controller(PostsController::class)->group(function () {
        Route::get('posts', 'index');
        Route::get('post/{post_id}', 'postById');
        Route::post('add-post', 'store');
        Route::put('edit-post/{post}', 'update');
        Route::delete('delete-post/{post}', 'destroy');
    });

    Route::get('feed', FeedController::class);
    Route::get('{post_id}/add-like/{user_id}', [LikesController::class, 'store']);

});

