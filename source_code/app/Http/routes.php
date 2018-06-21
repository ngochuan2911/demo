<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('logout', function () {
        \Auth::logout();
        return \Redirect::to('/login');
    });
});


Route::group(['prefix' => 'api'], function () {
    route::get('login', 'Api\AuthController@login');
    route::get('logout', 'Api\AuthController@logout');
    Route::get('update-profile', 'Api\UserController@UpdateProfile');
    Route::get('get-profile', 'Api\UserController@GetProfile');
});


Route::get('help-app', function() {
    return view('Fontend.Help.help');
});


