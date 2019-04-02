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

Route::middleware('auth:api')->get('/reserve/reserve_parking_events', 'ReserveController@reserveParkingEvents')
    ->name('reserve.reserve_parking_events');

// apiの認証に失敗した時のリダイレクト先にとりあえず設定
Route::get('/api/auth', 'ReserveController@failAuth')->name('login');