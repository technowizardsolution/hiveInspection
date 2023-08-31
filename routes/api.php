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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/updateMedia','API\ChatController@updateMedia');
Route::post('/saveLastMessage', 'API\FirebaseChatController@saveLastMessage'); // save last chat message


Route::group(['middleware' => 'localization'], function(){

  Route::post('/register', 'API\UserController@register');
  Route::post('/login', 'API\UserController@login');
  Route::post('/logout', 'API\UserController@logout');
  Route::post('/forgotPassword', 'API\UserController@forgotPassword');
  Route::post('/socialRegister', 'API\UserController@socialRegister');

  //get category
  Route::post('/category', 'API\UserController@getCategory');
  Route::post('/subcategory', 'API\UserController@getSubcategory');

  //country state city
  Route::get('/country', 'API\CountryController@country');
  Route::post('/state', 'API\CountryController@state');
  Route::post('/city', 'API\CountryController@city');

  // Verify OTP
  Route::post('/verifyMobile', 'API\UserController@verifyMobile');
  Route::post('/sendOTP', 'API\UserController@sendOTP');
  Route::post('/resetPassword', 'API\UserController@resetPassword');

  // ContactUS
  Route::post('/ContactUS', 'API\UserController@ContactUS');
  Route::get('/faq', 'API\UserController@faq');

  Route::post('/testnotification', 'API\UserController@testnotification');

  Route::post('editUserGame','API\UserGameController@editUserGame');
  Route::get('/bannerList','API\BannerController@bannerList');
	Route::group(['middleware' => 'auth:api'], function(){
    //User
    Route::post('/updateDeviceToken', 'API\UserController@updateDeviceToken');
    Route::post('/changePassword', 'API\UserController@changePassword');
    Route::post('/updateProfile','API\UserController@updateProfile');
    Route::post('/getProfile','API\UserController@getProfile');

    //Hive
    Route::post('/addUpdateHive', 'API\HiveController@addUpdateHive');
    Route::get('/getHiveById/{id}','API\HiveController@getHiveById');

    Route::post('/addInspection', 'API\InspectionController@addInspection');
    Route::get('/getInspectionById/{id}','API\InspectionController@getInspectionById');
    Route::get('/getInspectionHistory','API\InspectionController@getInspectionHistory');
    
    
  });
});
