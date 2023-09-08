<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
})->middleware('auth');
Auth::routes();

Route::post('apple/redirect', 'AppleController@redirect');
Route::get('/2fa/validate', 'Auth\LoginController@getValidateToken');
Route::post('/2fa/validate', ['middleware' => 'throttle:5', 'uses' => 'Auth\LoginController@postValidateToken']);

Route::group(['middleware' => ['web']], function () {

    Auth::routes(['verify' => true]);
    Route::get('/', 'HomeController@default');
    Route::get('/home', 'HomeController@default');

    // social login/register routes
    Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('googleLogin');
    Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
    Route::get('login/facebook', 'Auth\LoginController@redirectToFacebook')->name('facebookLogin');
    Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
    Route::get('login/twitter', 'Auth\LoginController@redirectToTwitter')->name('twitterLogin');
    Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterCallback');

    Route::get('login/zoho', 'Auth\LoginController@redirectToZoho')->name('zohoLogin');
    Route::get('login/zoho/callback', 'Auth\LoginController@handleZohoCallback');

    Route::get('sign-up', 'Auth\RegisterController@showRegistrationForm')->name('registerScreen');

    Route::get('/check-email-exsist', 'Admin\UserController@emailExsist');
    Route::get('/check-mac-address-exsist', 'Admin\UserController@macAddressExsist');
    Route::get('confirm_email', 'Admin\UserController@confirmEmail');

    // API Reset Password
    Route::get('reset/password/{token}', 'Auth\ResetPasswordController@resetPasswords');
    Route::post('reset/password', 'Auth\ResetPasswordController@updatePassword')->name('password.update');
    Route::get('/check-number-exsist', 'Admin\UserController@mobilenumberExsist');

    Route::get('/deactivate-account', 'CommonController@accountDeactivate');
    Route::post('/deactivate-account', 'CommonController@accountDeactivatePost');      
    
    Route::get('/about', 'CommonController@about');
    Route::get('/terms-privacy', 'CommonController@termsPrivacy');
    

    Route::group(['middleware' => ['auth']], function () {
        // Route::get('/home', 'HomeController@index');

        Route::post('/save-theam-mode', 'HomeController@saveTheamMode');

        Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function () {

            // Dashboard
            Route::get('/dashboard', 'DashboardController')->name('adminDashboard'); //Dashboard page
            Route::post('/dashboardFilterData', 'DashboardController@dashboardFilterData'); //Dashboard page

            // get user Data Month wise
            Route::get('/get-users', 'UserController@UserData')->name('getUsersData');

            // admin profile Routing
            Route::resource('/profile', 'ProfileController');            

            // User Routing
            Route::resource('/users', 'UserController');
            Route::post('/users/status-change', 'UserController@changeStatus');            

            // User Routing
            Route::resource('/subadmins', 'SubAdminController');
            Route::post('/subadmins/status-change', 'SubAdminController@changeStatus');            

            //Roles Routing
            // Route::resource('/roles','RoleController');
            Route::resource('roles', 'RoleController');
            Route::post('/permission/getPermissions', 'RoleController@getPermissions');

            //Role Users Routing
            Route::resource('/roleuser', 'RoleUserController');

            // Inspection
            Route::resource('/inspection', 'InspectionController');
            Route::post('/inspection/status-change', 'InspectionController@changeStatus');            

            // Hive
            Route::resource('/hive', 'HiveController');
            Route::post('/hive/status-change', 'HiveController@changeStatus');         
            
            //CMS Pages Routing
            Route::resource('/pages', 'CMSPagesController');
            Route::post('/pages/status-change', 'CMSPagesController@changeStatus');
           
        });

        Route::group(['prefix' => 'user', 'middleware' => ['role:user'], 'namespace' => 'User'], function () {
            // Hive
            Route::get('/hive', 'HiveController@index');
            Route::post('/hive/store', 'HiveController@store');

            // Inspection
            Route::get('/inspection/{id}', 'InspectionController@index');
            Route::post('/inspection/store', 'InspectionController@store');
            Route::get('/inspectionexport', 'InspectionController@inspectionExport');

        });

        

    });
});
Route::get('page-load', 'HomeController@pageLoad');
