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

Route::get('/', function() {
    return view('index');
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

