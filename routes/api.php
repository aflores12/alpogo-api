<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('users', 'UserController');

Route::group([
    'prefix' => 'user',
    'middleware' => 'accesstoken'
], function () {

    Route::get('/', 'UserController@show');

    Route::get('roles', 'RoleController@show');

    Route::post('roles', 'RoleController@attach');

    Route::delete('roles/{slug}', 'RoleController@detach');

});

Route::get('event/list', 'EventController@index');

Route::group([
   'prefix' => 'event',
    'middleware' => 'accesstoken'
], function () {

    Route::get('/', 'EventController@show');

    Route::post('/', 'EventController@store');

    Route::put('/{slug}', 'EventController@update');

});


Route::post('login', 'Auth\AuthController@login');
Route::post('registration', 'Auth\AuthController@registration');

Route::get('roles', 'RoleController@index');

Route::get('artists', 'ArtistController@index');
Route::get('users/{id}/artist', 'ArtistController@show');
Route::post('users/{id}/artist', 'ArtistController@attach');
Route::delete('users/{id}/artist', 'ArtistController@detach');


