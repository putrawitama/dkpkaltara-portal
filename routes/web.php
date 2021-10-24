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
    Route::get('/dashboard', 'HomeController@index')->name('home');

    Route::prefix('article')->group(function () {
        Route::get('/', 'ArticleController@index')->name('get.list-article');
        Route::get('/add', 'ArticleController@add')->name('get.add-article');
        Route::post('/list', 'ArticleController@list')->name('post.list-article');
        Route::post('/store', 'ArticleController@store')->name('post.store-article');
        Route::get('/edit/{id}', 'ArticleController@edit')->name('get.edit-article');
        Route::post('/update', 'ArticleController@update')->name('post.update-article');
        Route::get('/publish/{id}', 'ArticleController@publish')->name('post.publish-article');
        Route::get('/unpublish/{id}', 'ArticleController@unpublish')->name('post.unpublish-article');
        Route::get('/delete/{id}', 'ArticleController@delete')->name('post.delete-article');
    });

    Route::prefix('external')->group(function () {
        Route::get('/', 'ExternalController@index')->name('get.list-external');
        Route::get('/add', 'ExternalController@add')->name('get.add-external');
        Route::post('/list', 'ExternalController@list')->name('post.list-external');
        Route::post('/store', 'ExternalController@store')->name('post.store-external');
        Route::get('/edit/{id}', 'ExternalController@edit')->name('get.edit-external');
        Route::post('/update', 'ExternalController@update')->name('post.update-external');
        Route::get('/delete/{id}', 'ExternalController@delete')->name('post.delete-external');
    });
    Route::prefix('adsense')->group(function () {
        Route::get('/', 'AdsenseController@index')->name('get.list-adsense');
        Route::get('/add', 'AdsenseController@add')->name('get.add-adsense');
        Route::post('/list', 'AdsenseController@list')->name('post.list-adsense');
        Route::post('/store', 'AdsenseController@store')->name('post.store-adsense');
        Route::get('/edit/{id}', 'AdsenseController@edit')->name('get.edit-adsense');
        Route::post('/update', 'AdsenseController@update')->name('post.update-adsense');
        Route::get('/delete/{id}', 'AdsenseController@delete')->name('post.delete-adsense');
        Route::get('/publish/{id}', 'AdsenseController@publish')->name('post.publish-adsense');
        Route::get('/unpublish/{id}', 'AdsenseController@unpublish')->name('post.unpublish-adsense');
    });

    Route::prefix('mail')->group(function () {
        Route::get('/', 'MailController@index')->name('get.list-mail');
        Route::post('/list', 'MailController@list')->name('post.list-mail');
        Route::get('/detail/{id}', 'MailController@detail')->name('get.detail-mail');
        Route::get('/responded/{id}', 'MailController@responded')->name('post.responded-mail');
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', 'MenuController@index')->name('get.list-menu');
        Route::get('/add', 'MenuController@add')->name('get.add-menu');
        Route::post('/list', 'MenuController@list')->name('post.list-menu');
        Route::post('/store', 'MenuController@store')->name('post.store-menu');
        Route::get('/edit/{id}', 'MenuController@edit')->name('get.edit-menu');
        Route::post('/update', 'MenuController@update')->name('post.update-menu');
        Route::get('/delete/{id}', 'MenuController@delete')->name('post.delete-menu');
    });

    Route::prefix('gallery')->group(function () {
        Route::get('/', 'GalleryController@index')->name('get.list-gallery');
        Route::get('/add', 'GalleryController@add')->name('get.add-gallery');
        Route::post('/list', 'GalleryController@list')->name('post.list-gallery');
        Route::post('/store', 'GalleryController@store')->name('post.store-gallery');
        Route::get('/edit/{id}', 'GalleryController@edit')->name('get.edit-gallery');
        Route::post('/update', 'GalleryController@update')->name('post.update-gallery');
        Route::get('/publish/{id}', 'GalleryController@publish')->name('post.publish-gallery');
        Route::get('/unpublish/{id}', 'GalleryController@unpublish')->name('post.unpublish-gallery');
        Route::get('/delete/{id}', 'GalleryController@delete')->name('post.delete-gallery');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@index')->name('get.list-user');
        Route::get('/add', 'UserController@add')->name('get.add-user');
        Route::post('/list', 'UserController@list')->name('post.list-user');
        Route::post('/store', 'UserController@store')->name('post.store-user');
        Route::get('/edit/{id}', 'UserController@edit')->name('get.edit-user');
        Route::post('/update', 'UserController@update')->name('post.update-user');
        Route::get('/delete/{id}', 'UserController@delete')->name('post.delete-user');
    });
});

Route::get('/', 'LandingController@home')->name('landing.main');
Route::get('/page/{menu}/{article?}', 'LandingController@listArticleByMenu')->name('landing.detail');
Route::get('/kontak', 'MailController@contactUs')->name('landing.contact');
Route::post('/kontak-post', 'MailController@postContact')->name('landing.contact-post');
Route::get('/galeri/{type}/{id?}', 'LandingController@detailGallery')->name('landing.gallery.detail');

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