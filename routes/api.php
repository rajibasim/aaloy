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
    Route::post('signup', 'App\Http\Controllers\Application\API\MainController@signup');
    Route::post('signin', 'App\Http\Controllers\Application\API\MainController@signin');
    Route::post('resend', 'App\Http\Controllers\Application\API\MainController@resend');
    Route::post('verify', 'App\Http\Controllers\Application\API\MainController@verify');
    Route::post('forgot-password', 'App\Http\Controllers\Application\API\MainController@forgotPassword');
    Route::post('reset-password', 'App\Http\Controllers\Application\API\MainController@resetPassword');

});

Route::group(['prefix' => 'v1','middleware' => ['auth:api']], function () {
    	Route::post('logout', 'App\Http\Controllers\Application\API\MainController@logout');
    	Route::post('stock', 'App\Http\Controllers\Application\API\MainController@stock');
    	Route::post('history', 'App\Http\Controllers\Application\API\MainController@history');
    	Route::post('stockList', 'App\Http\Controllers\Application\API\MainController@stockList');
        Route::post('stockDetails', 'App\Http\Controllers\Application\API\MainController@stockDetails');
    	Route::post('stockEntry', 'App\Http\Controllers\Application\API\MainController@stockEntry');
        Route::post('stockUpdate', 'App\Http\Controllers\Application\API\MainController@stockUpdate');
    	Route::post('report', 'App\Http\Controllers\Application\API\MainController@report');
        Route::post('categoryBalance', 'App\Http\Controllers\Application\API\MainController@categoryBalance');
        Route::post('productBalance', 'App\Http\Controllers\Application\API\MainController@productBalance');
});
