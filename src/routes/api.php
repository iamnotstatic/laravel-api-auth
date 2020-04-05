<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

Route::group(['namespace'=>'Iamnotstatic\LaravelAPIAuth\Http\Controllers'], function() {

    Route::post('api/register', 'Auth\RegisterController@register')->name('register');
    Route::post('api/login', 'Auth\LoginController@login')->name('login');

});

