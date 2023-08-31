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

Route::post('callback-ended','Common\TwilioController@callbackEnded');
Route::post('record-callback-ended','Common\TwilioController@recordCallbackEnded');

Route::get('video-callback','Common\TwilioController@videoCallback');
Route::post('video-callback','Common\TwilioController@videoCallback');
