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
  Route::get('event/show' , 'Mountain\EventController@show')->middleware('auth');
  Route::get('event/delete', 'Mountain\EventController@delete')->middleware('auth');
  /* index画面で企画者名をオートコンプリートで検索させるために追加 20190923 start */
  Route::get('/event/autocomplete' , 'Mountain\EventController@search')->middleware('auth')->name('event.autocomplete');
  /* index画面で企画者名をオートコンプリートで検索させるために追加 20190923 end */

  /* index画面で参加者をオートコンプリートで検索させるために追加 20190923 start */
  // Route::get('/event/create/autocompletemember' , 'Mountain\EventController@search_member')->middleware('auth')->name('event.autocompletemember');
  /* index画面で参加者名をオートコンプリートで検索させるために追加 20190923 end */
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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function()
{
    Route::get('members', 'MemberCsvImportController@index')->name('members')->middleware('auth');
    Route::patch('members/upload', 'MemberCsvImportController@upload')->name('members.upload')->middleware('auth');
    Route::get('members/download', 'MemberCsvImportController@download')->name('members.download')->middleware('auth');

});
