<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('video-controls', function () {
    return view('components.video.controls')->render();
});

Route::prefix('metadata')
    ->group(function () {

        Route::prefix('artist')
            ->group(function () {
                Route::get('search', 'SpotifyAPIController@searchArtist');
            });

        Route::prefix('album')
            ->group(function () {
                Route::get('search', 'SpotifyAPIController@searchAlbum');
            });

        Route::prefix('song')
            ->group(function () {
                Route::get('search', 'SpotifyAPIController@searchSong');
            });

    });