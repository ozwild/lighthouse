<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to('records');
})->name('home');

Route::get('/app',function(){
    return view('app');
});

Route::resource('records', 'RecordController');

Route::prefix("records")
    ->group(function () {

        Route::get("{record}/sync", 'RecordController@getSync')
            ->name("records.lyrics.sync");

    });