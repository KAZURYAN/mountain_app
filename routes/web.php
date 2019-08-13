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

Route::group(['prefix' => 'mountain'], function() {
  Route::get('event/create' , 'Mountain\EventController@add')->middleware('auth');
  Route::post('event/create' , 'Mountain\EventController@create')->middleware('auth');
  Route::get('event' , 'Mountain\EventController@index')->middleware('auth');
  Route::get('event/edit' , 'Mountain\EventController@edit')->middleware('auth');
  Route::post('event/edit' , 'Mountain\EventController@update')->middleware('auth');
  Route::get('event/delete', 'Mountain\EventController@delete')->middleware('auth');
  Route::get('tag/create' , 'Mountain\TagController@add')->middleware('auth');
  Route::post('tag/create' , 'Mountain\TagController@create')->middleware('auth');
  Route::get('tag' , 'Mountain\TagController@index')->middleware('auth');
  Route::get('tag/edit' , 'Mountain\TagController@edit')->middleware('auth');
  Route::post('tag/edit' , 'Mountain\TagController@update')->middleware('auth');
  Route::get('tag/delete', 'Mountain\TagController@delete')->middleware('auth');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
