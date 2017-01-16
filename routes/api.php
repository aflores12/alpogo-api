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

Route::get('roles', 'RoleController@index');
Route::get('users/{id}/roles', 'RoleController@show');
Route::post('users/{id}/roles/', 'RoleController@attach');
Route::delete('users/{id}/roles/{slug}', 'RoleController@detach');

Route::get('artists', 'ArtistController@index');
Route::get('users/{id}/artist', 'ArtistController@show');
Route::post('users/{id}/artist', 'ArtistController@attach');
Route::delete('users/{id}/artist', 'ArtistController@detach');

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


