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
	Route::post('brand', 'App\Http\Controllers\Application\API\MainController@brand');
	Route::post('scheme', 'App\Http\Controllers\Application\API\MainController@scheme');
    Route::post('category', 'App\Http\Controllers\Application\API\MainController@category');
    Route::post('product', 'App\Http\Controllers\Application\API\MainController@product');
    Route::post('login', 'App\Http\Controllers\Application\API\MainController@login');
    Route::post('resend', 'App\Http\Controllers\Application\API\MainController@resend');
    Route::post('verify', 'App\Http\Controllers\Application\API\MainController@verify');
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
