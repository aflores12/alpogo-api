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

Route::group([
    'prefix' => 'user'
], function () {

    Route::get('/', 'UserController@show')->middleware('accesstoken');

    Route::get('list', 'UserController@index');

    Route::get('roles', 'RoleController@show')->middleware('accesstoken');

    Route::post('roles', 'RoleController@attach')->middleware('accesstoken');

    Route::delete('roles/{slug}', 'RoleController@detach')->middleware('accesstoken');

});

Route::get('event/list', 'EventController@index');

Route::group([
   'prefix' => 'event'
], function () {

    Route::get('/{slug}', 'EventController@show');

    Route::post('/', 'EventController@store');

    Route::put('/{slug}', 'EventController@update');

    Route::patch('/{slug}', 'EventController@partialUpdate');

    Route::get('/{slug}/items', 'EventController@items');

    Route::group([
        'prefix' => '{slug}/ticket'
    ] , function () {

        Route::post('/', 'TicketController@store');

        Route::get('/', 'TicketController@show');

        Route::put('/{id}', 'TicketController@update');

        Route::patch('/{id}', 'TicketController@partialUpdate');

    });

    Route::group([
        'prefix' => '{slug}/promotion'
    ] , function () {

        Route::post('/', 'PromotionController@store');

        Route::get('/', 'PromotionController@show');

        Route::put('/{id}', 'PromotionController@update');

        Route::patch('/{id}', 'PromotionController@partialUpdate');

    });

});

Route::group([
    'prefix' => 'item'
], function () {

    Route::get('/{id}', 'ItemController@show');

    Route::post('/{slug}/{slug_item_type}', 'ItemController@store');

    Route::put('/{id}', 'ItemController@update');

    Route::patch('/{id}', 'ItemController@partialUpdate');

    Route::delete('/{id}', 'ItemController@destroy');

    Route::group([
        'prefix' => 'type'
    ], function () {

        Route::get('{slug}', 'ItemTypeController@show');

        Route::post('/', 'ItemTypeController@store');

        Route::put('/{slug}', 'ItemTypeController@update');

        Route::delete('/{slug}', 'ItemTypeController@destroy');

    });

});

Route::group([
    'prefix' => 'account'
], function () {

    Route::post('login', 'Auth\AuthController@login');

    Route::post('registration', 'Auth\AuthController@registration');

});

Route::get('roles', 'RoleController@index');

Route::get('artists', 'ArtistController@index');
Route::get('users/{id}/artist', 'ArtistController@show');
Route::post('users/{id}/artist', 'ArtistController@attach');
Route::delete('users/{id}/artist', 'ArtistController@detach');


