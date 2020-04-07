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

    Route::group(['prefix' => 'api'], function() {
        
        Route::post('register', 'Auth\RegisterController@register')->name('register');
        Route::post('login', 'Auth\LoginController@login')->name('login');

        Route::post('password/forgotten', 'Auth\ForgotPasswordController@forgotten');
        Route::get('password/find/{token}', 'Auth\PasswordResetController@find');
        Route::post('password/reset', 'Api\Password\PasswordResetController@reset');

    });
    
});

