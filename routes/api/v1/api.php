<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login')->name('api.auth.login');
    Route::post('signup', 'AuthController@signup')->name('api.auth.signup');

    Route::prefix('etfs')->middleware('auth:api')->group(function () {
        Route::get('/', 'ETFController@index')->name('api.etfs.index');
        Route::get('symbols', 'ETFController@listAllSymbols')->name('api.etfs.symbols');
        Route::get('symbols/{symbol}', 'ETFController@show')->name('api.etfs.show');
    });
});
