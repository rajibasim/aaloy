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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'v1'],  function(){     
	Route::get('master-data', 'App\Http\Controllers\Application\API\MainController@masterData');
	Route::get('banner', 'App\Http\Controllers\Application\API\MainController@banner');
    Route::get('accessory', 'App\Http\Controllers\Application\API\MainController@accessory');
    Route::get('location', 'App\Http\Controllers\Application\API\MainController@location');
    Route::get('blog/{id?}', 'App\Http\Controllers\Application\API\MainController@blog');
    Route::post('signup', 'App\Http\Controllers\Application\API\MainController@signup');
    Route::post('signin', 'App\Http\Controllers\Application\API\MainController@signin');
    Route::post('resend', 'App\Http\Controllers\Application\API\MainController@resend');
    Route::post('verify', 'App\Http\Controllers\Application\API\MainController@verify');
    Route::post('forgot-password', 'App\Http\Controllers\Application\API\MainController@forgotPassword');
    Route::post('reset-password', 'App\Http\Controllers\Application\API\MainController@resetPassword');
});

Route::group(['prefix' => 'v1','middleware' => ['auth:api']], function () {
        //Property Related Information
    	Route::any('logout', 'App\Http\Controllers\Application\API\UserController@logout');
        Route::post('updateProfile', 'App\Http\Controllers\Application\API\UserController@updateProfile');
        Route::post('property/list', 'App\Http\Controllers\Application\API\PropertyController@list');
    	Route::post('property/add', 'App\Http\Controllers\Application\API\PropertyController@add');
    	Route::post('property/edit/{id}', 'App\Http\Controllers\Application\API\PropertyController@edit');
        Route::post('property/delete/{id}', 'App\Http\Controllers\Application\API\PropertyController@delete');
    	Route::post('property/details/{id}', 'App\Http\Controllers\Application\API\PropertyController@details');
        Route::post('property/favorite/{id}', 'App\Http\Controllers\Application\API\PropertyController@favorite');
        Route::post('property/my-property', 'App\Http\Controllers\Application\API\PropertyController@myProperty');
        Route::post('property/my-booked-property', 'App\Http\Controllers\Application\API\PropertyController@myBookedProperty');
        Route::post('property/my-earning', 'App\Http\Controllers\Application\API\PropertyController@myEarning');
        Route::post('property/my-favorite-property', 'App\Http\Controllers\Application\API\PropertyController@myFavoriteProperty');
        Route::post('property/visit/{id}', 'App\Http\Controllers\Application\API\PropertyController@visit');
        Route::post('property/callBack/{id}', 'App\Http\Controllers\Application\API\PropertyController@callBack');
        Route::post('property/calculate', 'App\Http\Controllers\Application\API\PropertyController@calculate');
        Route::post('property/payment', 'App\Http\Controllers\Application\API\PropertyController@payment');
        Route::post('/process-login', 'App\Http\Controllers\Application\Web\UserController@processLogin');
        Route::post('/property/re-post/{id}', 'App\Http\Controllers\Application\API\PropertyController@re_post');
        Route::post('property/change-status/{id}', 'App\Http\Controllers\Application\API\PropertyController@change_status');

        //User Related Information
});
