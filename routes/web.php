<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('authuser')->group(function(){
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('gallery')->group(function () {
        Route::get('/', 'GalleryController@index')->name('get.list-gallery');
        Route::post('/list', 'GalleryController@list')->name('post.list-gallery');
        Route::get('/add', 'GalleryController@add')->name('get.add-gallery');
        Route::post('/store', 'GalleryController@store')->name('post.store-gallery');
        Route::get('/edit/{id}', 'GalleryController@edit')->name('get.edit-gallery');
        Route::post('/update', 'GalleryController@update')->name('post.update-gallery');
        Route::get('/publish/{id}', 'GalleryController@publish')->name('post.publish-gallery');
        Route::get('/unpublish/{id}', 'GalleryController@unpublish')->name('post.unpublish-gallery');
        Route::get('/delete/{id}', 'GalleryController@delete')->name('post.delete-gallery');
    });

    Route::prefix('jobs')->group(function () {
        Route::get('/', 'JobsController@index')->name('get.list-jobs');
        Route::post('/list', 'JobsController@list')->name('post.list-jobs');
        Route::get('/add', 'JobsController@add')->name('get.add-jobs');
        Route::post('/store', 'JobsController@store')->name('post.store-jobs');
    });

    Route::prefix('applicant')->group(function () {
        Route::get('/', 'ApplicantController@index')->name('get.list-applicant');
        Route::post('/list', 'ApplicantController@list')->name('post.list-applicant');
    });
});

// Login
Route::get('/login', 'LoginController@viewLogin')->name('get.login');
Route::post('/post-login', 'LoginController@postLogin')->name('post.login');

Route::prefix('logout')->group(function () {
    Route::get('/', 'LoginController@logout')->name('get.logout');
});

Route::prefix('s')->group(function () {
	Route::post('/', 'Security\EncryptController@getPass')->name('s');
});
Route::get('checkSession', 'LoginController@checkSession');