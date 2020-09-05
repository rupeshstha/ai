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

use App\UserCounter;

Route::get('/', function() {
    $user_count = UserCounter::where('id', 1)->first();
    return view('index',compact('user_count'));
})->name('home');

// Admin Routes
Route::group(['prefix' => 'admin'], function() {
    Voyager::routes();
});

// Sitemap Routes
Route::group(['as' => 'sitemaps.'], function() {
	$namespacePrefix = '\\'.config('voyager.controllers.namespace').'\\';
	Route::get('/sitemap.xml', $namespacePrefix.'SitemapController@index')->name('index');
	Route::get('/sitemap-{page?}.xml', $namespacePrefix.'SitemapController@page')->name('dynamic');
});

Route::get('store-data','SupportController@store')->name('store');
Route::post('test-data','SupportController@test')->name('test');

