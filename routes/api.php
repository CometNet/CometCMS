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
Route::middleware('api')->post('/user/logout', 'AuthController@logout');
Route::middleware('auth:api')->get('/user/info', 'AuthController@info');

Route::middleware('auth:api')->get('/user/list', 'UserController@list');
Route::middleware('auth:api')->resource('/user', 'UserController');

Route::middleware('auth:api')->get('/nav/list', 'NavigationController@list');
Route::middleware('auth:api')->get('/nav/all', 'NavigationController@getAllList');
Route::middleware('auth:api')->resource('/nav', 'NavigationController');

Route::middleware('auth:api')->post('/menu/list', 'MenuController@list');
Route::middleware('auth:api')->resource('/menu', 'MenuController');

Route::middleware('auth:api')->get('/slide_classify/list', 'SlideController@listClassify');
Route::middleware('auth:api')->get('/slide_classify/all', 'SlideController@getAllList');
Route::middleware('auth:api')->resource('/slide_classify', 'SlideController');

Route::middleware('auth:api')->post('/slide/list', 'SlideItemController@list');
Route::middleware('auth:api')->resource('/slide', 'SlideItemController');

Route::middleware('auth:api')->get('/option/list', 'OptionController@list');
Route::middleware('auth:api')->resource('/option', 'OptionController');

Route::middleware('api')->post('/user/register', 'AuthController@register');
Route::middleware('api')->post('/upload/file', 'UploadController@uploadFile');
