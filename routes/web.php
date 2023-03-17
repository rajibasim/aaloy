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
        /* district Start */
        Route::get('/admin-district', [App\Http\Controllers\Application\Admin\Masterdata\DistrictController::class, 'index'])->name('admin-district');
        Route::get('/admin-district/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\DistrictController::class, 'form'])->name('form');
        Route::post('/admin-district/save', [App\Http\Controllers\Application\Admin\Masterdata\DistrictController::class, 'save'])->name('save');
        Route::get('/admin-district/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\DistrictController::class, 'delete'])->name('delete');
        /* district End */
        /* category Start */
        Route::get('/admin-category', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'index'])->name('admin-category');
        Route::get('/admin-category/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'form'])->name('form');
        Route::post('/admin-category/save', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'save'])->name('save');
        Route::get('/admin-category/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\CategoryController::class, 'delete'])->name('delete');
        /* category End */
        /* unit Start */
        Route::get('/admin-unit', [App\Http\Controllers\Application\Admin\Masterdata\UnitController::class, 'index'])->name('admin-unit');
        Route::get('/admin-unit/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\UnitController::class, 'form'])->name('form');
        Route::post('/admin-unit/save', [App\Http\Controllers\Application\Admin\Masterdata\UnitController::class, 'save'])->name('save');
        Route::get('/admin-unit/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\UnitController::class, 'delete'])->name('delete');
        /* unit End */
        /* scheme Start */
        Route::get('/admin-scheme', [App\Http\Controllers\Application\Admin\Masterdata\SchemeController::class, 'index'])->name('admin-scheme');
        Route::get('/admin-scheme/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\SchemeController::class, 'form'])->name('form');
        Route::post('/admin-scheme/save', [App\Http\Controllers\Application\Admin\Masterdata\SchemeController::class, 'save'])->name('save');
        Route::get('/admin-scheme/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\SchemeController::class, 'delete'])->name('delete');
        /* scheme End */
        /* designation Start */
        Route::get('/admin-designation', [App\Http\Controllers\Application\Admin\Masterdata\DesignationController::class, 'index'])->name('admin-designation');
        Route::get('/admin-designation/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\DesignationController::class, 'form'])->name('form');
        Route::post('/admin-designation/save', [App\Http\Controllers\Application\Admin\Masterdata\DesignationController::class, 'save'])->name('save');
        Route::get('/admin-designation/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\DesignationController::class, 'delete'])->name('delete');
        /* designation End */
        /* brand Start */
        Route::get('/admin-brand', [App\Http\Controllers\Application\Admin\Masterdata\BrandController::class, 'index'])->name('admin-brand');
        Route::get('/admin-brand/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\BrandController::class, 'form'])->name('form');
        Route::post('/admin-brand/save', [App\Http\Controllers\Application\Admin\Masterdata\BrandController::class, 'save'])->name('save');
        Route::get('/admin-brand/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\BrandController::class, 'delete'])->name('delete');
        /* brand End */

         /* subdevision Start */
        Route::get('/admin-subdevision', [App\Http\Controllers\Application\Admin\Masterdata\SubdevisionController::class, 'index'])->name('admin-subdevision');
        Route::get('/admin-subdevision/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\SubdevisionController::class, 'form'])->name('form');
        Route::post('/admin-subdevision/save', [App\Http\Controllers\Application\Admin\Masterdata\SubdevisionController::class, 'save'])->name('save');
        Route::get('/admin-subdevision/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\SubdevisionController::class, 'delete'])->name('delete');
        /* subdevision End */

         /* block Start */
        Route::get('/admin-block', [App\Http\Controllers\Application\Admin\Masterdata\BlockController::class, 'index'])->name('admin-block');
        Route::get('/admin-block/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\BlockController::class, 'form'])->name('form');
        Route::post('/admin-block/save', [App\Http\Controllers\Application\Admin\Masterdata\BlockController::class, 'save'])->name('save');
        Route::get('/admin-block/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\BlockController::class, 'delete'])->name('delete');
        /* block End */

         /* panchanyat Start */
        Route::get('/admin-panchanyat', [App\Http\Controllers\Application\Admin\Masterdata\PanchanyatController::class, 'index'])->name('admin-panchanyat');
        Route::get('/admin-panchanyat/form/{id?}', [App\Http\Controllers\Application\Admin\Masterdata\PanchanyatController::class, 'form'])->name('form');
        Route::post('/admin-panchanyat/save', [App\Http\Controllers\Application\Admin\Masterdata\PanchanyatController::class, 'save'])->name('save');
        Route::get('/admin-panchanyat/delete/{id}', [App\Http\Controllers\Application\Admin\Masterdata\PanchanyatController::class, 'delete'])->name('delete');
        /* panchanyat End */
    });
    /*master data end*/

    /*store start*/
    Route::group(['prefix' => '/store'], function () {
        /* district-store Start */
        Route::get('/admin-district-store', [App\Http\Controllers\Application\Admin\Store\DistrictstoreController::class, 'index'])->name('admin-district-store');
        Route::get('/admin-district-store/form/{id?}', [App\Http\Controllers\Application\Admin\Store\DistrictstoreController::class, 'form'])->name('form');
        Route::post('/admin-district-store/save', [App\Http\Controllers\Application\Admin\Store\DistrictstoreController::class, 'save'])->name('save');
        Route::get('/admin-district-store/delete/{id}', [App\Http\Controllers\Application\Admin\Store\DistrictstoreController::class, 'delete'])->name('delete');
        /* district-store End */
        /* main-store Start */
        Route::get('/admin-main-store', [App\Http\Controllers\Application\Admin\Store\MainstoreController::class, 'index'])->name('admin-main-store');
        Route::get('/admin-main-store/form/{id?}', [App\Http\Controllers\Application\Admin\Store\MainstoreController::class, 'form'])->name('form');
        Route::post('/admin-main-store/save', [App\Http\Controllers\Application\Admin\Store\MainstoreController::class, 'save'])->name('save');
        Route::get('/admin-main-store/delete/{id}', [App\Http\Controllers\Application\Admin\Store\MainstoreController::class, 'delete'])->name('delete');
        /* main-store End */
        /* subseed-store Start */
        Route::get('/admin-subseed-store', [App\Http\Controllers\Application\Admin\Store\SubseedstoreController::class, 'index'])->name('admin-subseed-store');
        Route::get('/admin-subseed-store/form/{id?}', [App\Http\Controllers\Application\Admin\Store\SubseedstoreController::class, 'form'])->name('form');
        Route::post('/admin-subseed-store/save', [App\Http\Controllers\Application\Admin\Store\SubseedstoreController::class, 'save'])->name('save');
        Route::get('/admin-subseed-store/delete/{id}', [App\Http\Controllers\Application\Admin\Store\SubseedstoreController::class, 'delete'])->name('delete');
        /* subseed-store End */
    });
    /*store end*/

    /* product Start */
    Route::get('/admin-product', [App\Http\Controllers\Application\Admin\ProductController::class, 'index'])->name('admin-product');
    Route::get('/admin-product/form/{id?}', [App\Http\Controllers\Application\Admin\ProductController::class, 'form'])->name('form');
    Route::post('/admin-product/save', [App\Http\Controllers\Application\Admin\ProductController::class, 'save'])->name('save');
    Route::get('/admin-product/delete/{id}', [App\Http\Controllers\Application\Admin\ProductController::class, 'delete'])->name('delete');
    Route::get('/admin-product/details/{id?}', [App\Http\Controllers\Application\Admin\ProductController::class, 'details'])->name('details');
    Route::any('/admin-product/update-stock', [App\Http\Controllers\Application\Admin\ProductController::class, 'updatestock'])->name('update-stock');
    /* product End */

     /* users Start */
    Route::get('/admin-users', [App\Http\Controllers\Application\Admin\UsersController::class, 'index'])->name('admin-users');
    Route::get('/admin-users/form/{id?}', [App\Http\Controllers\Application\Admin\UsersController::class, 'form'])->name('form');
    Route::post('/admin-users/save', [App\Http\Controllers\Application\Admin\UsersController::class, 'save'])->name('save');
    Route::get('/admin-users/delete/{id}', [App\Http\Controllers\Application\Admin\UsersController::class, 'delete'])->name('delete');
    /* users End */

    /* report Start */
    Route::get('/admin-report', [App\Http\Controllers\Application\Admin\ReportController::class, 'index'])->name('admin-report');
    /* report end */

    /* balance sheet Start */
    Route::get('/admin-product-balance', [App\Http\Controllers\Application\Admin\BalanceController::class, 'product'])->name('admin-product-balance');
    Route::get('/admin-product-category-balance', [App\Http\Controllers\Application\Admin\BalanceController::class, 'category'])->name('admin-product-category-balance');
    /* balance sheet end */
    
    /*stock start*/
    Route::group(['prefix' => '/stock'], function () {
        /* district-stock Start */
        Route::get('/district-store/admin-district-stock', [App\Http\Controllers\Application\Admin\stock\DistrictstockController::class, 'index'])->name('admin-district-stock');
        Route::get('/district-store/admin-district-history', [App\Http\Controllers\Application\Admin\stock\DistrictstockController::class, 'history'])->name('admin-district-history');
        Route::get('/district-store/admin-district-stock/form/{id?}', [App\Http\Controllers\Application\Admin\stock\DistrictstockController::class, 'form'])->name('form');
        Route::post('/district-store/admin-district-stock/save', [App\Http\Controllers\Application\Admin\stock\DistrictstockController::class, 'save'])->name('save');
        Route::get('/district-store/admin-district-stock/delete/{id}', [App\Http\Controllers\Application\Admin\stock\DistrictstockController::class, 'delete'])->name('delete');
        /* district-stock End */
        /* main-stock Start */
        Route::get('/main-store/admin-main-stock', [App\Http\Controllers\Application\Admin\stock\MainstockController::class, 'index'])->name('admin-main-stock');
        Route::get('/main-store/admin-main-history', [App\Http\Controllers\Application\Admin\stock\MainstockController::class, 'history'])->name('admin-main-history');
        Route::get('/main-store/admin-main-stock/form/{id?}', [App\Http\Controllers\Application\Admin\stock\MainstockController::class, 'form'])->name('form');
        Route::post('/main-store/admin-main-stock/save', [App\Http\Controllers\Application\Admin\stock\MainstockController::class, 'save'])->name('save');
        Route::get('/main-store/admin-main-stock/delete/{id}', [App\Http\Controllers\Application\Admin\stock\MainstockController::class, 'delete'])->name('delete');
        /* main-stock End */
        /* subseed-stock Start */
        Route::get('/subseed-store/admin-subseed-stock', [App\Http\Controllers\Application\Admin\stock\SubseedstockController::class, 'index'])->name('admin-subseed-stock');
        Route::get('/subseed-store/admin-subseed-history', [App\Http\Controllers\Application\Admin\stock\SubseedstockController::class, 'history'])->name('admin-subseed-history');
        Route::get('/subseed-store/admin-subseed-stock/form/{id?}', [App\Http\Controllers\Application\Admin\stock\SubseedstockController::class, 'form'])->name('form');
        Route::post('/subseed-store/admin-subseed-stock/save', [App\Http\Controllers\Application\Admin\stock\SubseedstockController::class, 'save'])->name('save');
        Route::get('/subseed-store/admin-subseed-stock/delete/{id}', [App\Http\Controllers\Application\Admin\stock\SubseedstockController::class, 'delete'])->name('delete');
        /* subseed-stock End */
    });
    /*stock end*/

    
});




