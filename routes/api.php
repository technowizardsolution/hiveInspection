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

  
  Route::post('/resetPassword', 'API\UserController@resetPassword');  
  Route::post('/testnotification', 'API\UserController@testnotification');
  
  Route::post('/getCMSpages', 'CommonController@getCMSpages');

  

	Route::group(['middleware' => 'auth:api'], function(){
    //User
    Route::post('/updateDeviceToken', 'API\UserController@updateDeviceToken');
    Route::post('/changePassword', 'API\UserController@changePassword');
    Route::post('/updateProfile','API\UserController@updateProfile');
    Route::post('/getProfile','API\UserController@getProfile');

    //Hive
    Route::get('/getHiveList','API\HiveController@getHiveList');
    Route::post('/addUpdateHive', 'API\HiveController@addUpdateHive');
    Route::get('/getHiveById/{id}','API\HiveController@getHiveById');
    Route::post('/deleteHive','API\HiveController@deleteHive');

    Route::post('/addInspection', 'API\InspectionController@addInspection');
    Route::get('/getInspectionById/{id}','API\InspectionController@getInspectionById');
    Route::get('/getInspectionHistory','API\InspectionController@getInspectionHistory');
    Route::post('/inspectionExport', 'API\InspectionController@inspectionExport');
    
    
    
  });
});
