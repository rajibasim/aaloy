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
Route::get('/', 'App\Http\Controllers\Application\Web\HomeController@home');
Route::get('/process-login', 'App\Http\Controllers\Application\Web\HomeController@processLogin');
Route::get('/app-blogs/{slug?}', 'App\Http\Controllers\Application\Web\AppCmsController@appBlogs');
Route::get('/app-page/{page_slug}', 'App\Http\Controllers\Application\Web\AppCmsController@appCmsPage');
Route::group(['middleware' => ['checkSessionWeb']], function() {
    Route::get('/blogs/{slug?}', 'App\Http\Controllers\Application\Web\HomeController@blogs');
    Route::get('/page/{page_slug}', 'App\Http\Controllers\Application\Web\HomeController@cmsPage');
});
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
    /* cms Start */
    Route::get('/cms', [App\Http\Controllers\Application\Admin\CmsController::class, 'index'])->name('cms');
    Route::get('/cms/form/{id?}', [App\Http\Controllers\Application\Admin\CmsController::class, 'form'])->name('form');
    Route::post('/cms/save', [App\Http\Controllers\Application\Admin\CmsController::class, 'save'])->name('save');
    Route::get('/cms/delete/{id}', [App\Http\Controllers\Application\Admin\CmsController::class, 'delete'])->name('delete');
    /* cms End */
    /* banner Start */
    Route::get('/banner', [App\Http\Controllers\Application\Admin\BannerController::class, 'index'])->name('banner');
    Route::get('/banner/form/{id?}', [App\Http\Controllers\Application\Admin\BannerController::class, 'form'])->name('form');
    Route::post('/banner/save', [App\Http\Controllers\Application\Admin\BannerController::class, 'save'])->name('save');
    Route::get('/banner/delete/{id}', [App\Http\Controllers\Application\Admin\BannerController::class, 'delete'])->name('delete');
    /* banner End */
    /* blog Start */
    Route::get('/blog', [App\Http\Controllers\Application\Admin\BlogController::class, 'index'])->name('blog');
    Route::get('/blog/form/{id?}', [App\Http\Controllers\Application\Admin\BlogController::class, 'form'])->name('form');
    Route::post('/blog/save', [App\Http\Controllers\Application\Admin\BlogController::class, 'save'])->name('save');
    Route::get('/blog/delete/{id}', [App\Http\Controllers\Application\Admin\BlogController::class, 'delete'])->name('delete');
    /* blog End */
    /* food Start */
    Route::get('/food', [App\Http\Controllers\Application\Admin\FoodController::class, 'index'])->name('food');
    Route::get('/food/form/{id?}', [App\Http\Controllers\Application\Admin\FoodController::class, 'form'])->name('form');
    Route::post('/food/save', [App\Http\Controllers\Application\Admin\FoodController::class, 'save'])->name('save');
    Route::get('/food/delete/{id}', [App\Http\Controllers\Application\Admin\FoodController::class, 'delete'])->name('delete');
    /* food End */
     /* property Start */
    Route::get('/property', [App\Http\Controllers\Application\Admin\PropertyController::class, 'index'])->name('property');
    Route::get('/property/form/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'form'])->name('form');
    Route::post('/property/save', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save'])->name('save');
    Route::get('/property/delete/{id}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete'])->name('delete');
    Route::get('/property/details/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'details'])->name('details');
    Route::post('/property/save_image', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save_image'])->name('save_image');
    Route::post('/property/save_food', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save_food'])->name('save_food');
    Route::get('/property/delete_image/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete_image'])->name('delete_image');
    Route::get('/property/delete_food/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete_food'])->name('delete_food');
    /* property End */

    /*User data start*/
    Route::group(['prefix' => '/users'], function () {
        /* agent Start */
        Route::get('/agent', [App\Http\Controllers\Application\Admin\Users\AgentController::class, 'index'])->name('admin-district');
        Route::get('/agent/form/{id?}', [App\Http\Controllers\Application\Admin\Users\AgentController::class, 'form'])->name('form');
        Route::post('/agent/save', [App\Http\Controllers\Application\Admin\Users\AgentController::class, 'save'])->name('save');
        Route::get('/agent/delete/{id}', [App\Http\Controllers\Application\Admin\Users\AgentController::class, 'delete'])->name('delete');
        /* agent End */

        /* user Start */
        Route::get('/user', [App\Http\Controllers\Application\Admin\Users\UserController::class, 'index'])->name('admin-district');
        Route::get('/user/form/{id?}', [App\Http\Controllers\Application\Admin\Users\UserController::class, 'form'])->name('form');
        Route::post('/user/save', [App\Http\Controllers\Application\Admin\Users\UserController::class, 'save'])->name('save');
        Route::get('/user/delete/{id}', [App\Http\Controllers\Application\Admin\Users\UserController::class, 'delete'])->name('delete');
        /* user End */
    }); 

     /* Visit request */
    Route::get('/visit-request', [App\Http\Controllers\Application\Admin\VisitController::class, 'index'])->name('visit-request');
    Route::get('/visit-request/change-status', [App\Http\Controllers\Application\Admin\VisitController::class, 'changeStatus'])->name('change-status');

     /* Call Back */
    Route::get('/call-back-request', [App\Http\Controllers\Application\Admin\CallController::class, 'index'])->name('call-back-request');
    Route::get('/call-back-request/change-status', [App\Http\Controllers\Application\Admin\CallController::class, 'changeStatus'])->name('change-status');

    Route::get('/booking-history', [App\Http\Controllers\Application\Admin\BookingController::class, 'index'])->name('booking-history');
    
    /*Route::get('/property/form/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'form'])->name('form');
    Route::post('/property/save', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save'])->name('save');
    Route::get('/property/delete/{id}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete'])->name('delete');
    Route::get('/property/details/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'details'])->name('details');
    Route::post('/property/save_image', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save_image'])->name('save_image');
    Route::post('/property/save_food', [App\Http\Controllers\Application\Admin\PropertyController::class, 'save_food'])->name('save_food');
    Route::get('/property/delete_image/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete_image'])->name('delete_image');
    Route::get('/property/delete_food/{id?}', [App\Http\Controllers\Application\Admin\PropertyController::class, 'delete_food'])->name('delete_food');*/
    /* property End */   
    
});




