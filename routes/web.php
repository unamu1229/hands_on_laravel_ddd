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

Route::get('/parking/entry', 'ParkingController@entry')->name('parking.entry');

Route::post('/parking/create', 'ParkingController@create')->name('parking.create');
