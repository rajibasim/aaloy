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

/*
|-------------------------------------------------------------------------
|App Admin Route
|------------------------------------------------------------------------
*/

Route::get('admin-login', 'App\Http\Controllers\Application\Auth\AdminAuthController@admin_login');
Route::post('admin-post-login', 'App\Http\Controllers\Application\Auth\AdminAuthController@post_login');
Route::get('admin-logout', 'App\Http\Controllers\Application\Auth\AdminAuthController@admin_logout');
Route::any('reset-password', 'App\Http\Controllers\Application\admin\AdminController@reset_password');
Route::any('process-reset-password', 'App\Http\Controllers\Application\admin\AdminController@process_reset_password');


Route::group(['middleware' => ['checkAdminLogin']], function() {
    Route::get('admin-dashboard', 'App\Http\Controllers\Application\Admin\DashboardController@get_admin_dashboard');

    /*master data start*/
    Route::group(['prefix' => '/masterdata'], function () {
        /* location Start */
        Route::get('/location', [App\Http\Controllers\Application\Admin\Masterdata\LocationController::class, 'index'])->name('admin-district');
        Route::get('/location/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\LocationController::class, 'form'])->name('form');
        Route::post('/location/save', [App\Http\Controllers\Application\Admin\Masterdata\LocationController::class, 'save'])->name('save');
        Route::get('/location/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\LocationController::class, 'delete'])->name('delete');
        /* location End */
        /* country Start */
        Route::get('/country', [App\Http\Controllers\Application\Admin\Masterdata\CountryController::class, 'index'])->name('country');
        Route::get('/country/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\CountryController::class, 'form'])->name('form');
        Route::post('/country/save', [App\Http\Controllers\Application\Admin\Masterdata\CountryController::class, 'save'])->name('save');
        Route::get('/country/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\CountryController::class, 'delete'])->name('delete');
        /* country End */
        /* state Start */
        Route::get('/state', [App\Http\Controllers\Application\Admin\Masterdata\StateController::class, 'index'])->name('state');
        Route::get('/state/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\StateController::class, 'form'])->name('form');
        Route::post('/state/save', [App\Http\Controllers\Application\Admin\Masterdata\StateController::class, 'save'])->name('save');
        Route::get('/state/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\StateController::class, 'delete'])->name('delete');
        /* state End */
        /* city Start */
        Route::get('/city', [App\Http\Controllers\Application\Admin\Masterdata\CityController::class, 'index'])->name('city');
        Route::get('/city/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\CityController::class, 'form'])->name('form');
        Route::post('/city/save', [App\Http\Controllers\Application\Admin\Masterdata\CityController::class, 'save'])->name('save');
        Route::get('/city/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\CityController::class, 'delete'])->name('delete');
        /* city End */        
        /* category Start */
        Route::get('/category', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'index'])->name('category');
        Route::get('/category/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'form'])->name('form');
        Route::post('/category/save', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'save'])->name('save');
        Route::get('/category/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'delete'])->name('delete');
        /* category End */
        
    });
    /*master data end*/

    /* accessory Start */
    Route::get('/accessory', [App\Http\Controllers\Application\Admin\AccessoryController::class, 'index'])->name('accessory');
    Route::get('/accessory/form/{id?}', [App\Http\Controllers\Application\Admin\AccessoryController::class, 'form'])->name('form');
    Route::post('/accessory/save', [App\Http\Controllers\Application\Admin\AccessoryController::class, 'save'])->name('save');
    Route::get('/accessory/delete/{id}', [App\Http\Controllers\Application\Admin\AccessoryController::class, 'delete'])->name('delete');
    /* accessory End */
    /* banner Start */
    Route::get('/banner', [App\Http\Controllers\Application\Admin\BannerController::class, 'index'])->name('banner');
    Route::get('/banner/form/{id?}', [App\Http\Controllers\Application\Admin\BannerController::class, 'form'])->name('form');
    Route::post('/banner/save', [App\Http\Controllers\Application\Admin\BannerController::class, 'save'])->name('save');
    Route::get('/banner/delete/{id}', [App\Http\Controllers\Application\Admin\BannerController::class, 'delete'])->name('delete');
    /* banner End */

    
});




