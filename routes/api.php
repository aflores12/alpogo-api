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

Route::get('users/{id}/roles', 'RoleController@show');
Route::post('users/{id}/roles/attach', 'RoleController@attach');
Route::post('users/{id}/roles/detach', 'RoleController@detach');
Route::get('users/{id}/roles/permissions', 'UserController@permissions');

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


