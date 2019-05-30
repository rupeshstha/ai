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
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('chart_data/{chart?}', 'ChartController@chart_data')->name('admin.chart_data');
    Route::get('realtime_data', 'ChartController@realtime_data')->name('admin.realtime_data');
});
