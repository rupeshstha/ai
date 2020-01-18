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
})->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('forgot-password', 'Admin\ForgotPasswordController@index')->name('admin.forgot_password.index');
    Route::post('forgot-password', 'Admin\ForgotPasswordController@reset')->name('admin.forgot_password.reset');
    Route::get('forgot-password/{token}', 'Admin\ForgotPasswordController@token')->name('admin.forgot_password.token');
    Route::put('forgot-password/{token}', 'Admin\ForgotPasswordController@update')->name('admin.forgot_password.update');
});

// Sitemap Routes
Route::get('/sitemap.xml', 'Admin\SitemapController@index')->name('sitemaps.index');
Route::get('/sitemap-{page?}.xml', 'Admin\SitemapController@page')->name('sitemaps.dynamic');