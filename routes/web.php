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


Route::get('/test/get', 'MailTestController@testGet');

Route::get('/test/temp', 'MailTestController@testTemp');

Route::get('/test/contact', 'MailTestController@testContact');

Route::get('/test/contact/create', 'MailTestController@testContactCreate');
Route::get('/test/contact/update', 'MailTestController@testContactUpdate');
Route::get('/test/contact/mega', 'MailTestController@testMega');
Route::get('/test/contact/mega/update', 'MailTestController@testMegaUpdate');
Route::get('/test/contact/list/create', 'MailTestController@testContactList');

Route::get('/test/piwik', 'PiwikTestController@testPiwik');

//Route::group(['middlewareGroups' => 'web'], function () {
    Route::get('/test/di', 'MailTestController@testDependency');
    Route::get('/test/send', 'MailTestController@testSend');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
