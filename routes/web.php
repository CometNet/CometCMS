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

Route::get('/', 'FrontEnd\IndexController@index');
Route::get('/{alias}.html', 'FrontEnd\IndexController@show');
Route::get('/categorys/{category}', 'FrontEnd\IndexController@index');
Route::get('/search/{keyword}', 'FrontEnd\IndexController@search');

Route::get('/wap', function () {
    return view('wap');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::namespace('FrontEnd')->group(function () {
    Route::get('/test', 'IndexController@index');
});

