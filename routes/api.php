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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('api')->post('/user/login', 'AuthController@login');
Route::middleware('auth:api')->get('/user/info', 'AuthController@info');
Route::middleware('auth:api')->get('/nav/list', 'NavigationController@list');
Route::middleware('auth:api')->post('/nav/add', 'NavigationController@add');
Route::middleware('api')->post('/user/register', 'AuthController@register');
