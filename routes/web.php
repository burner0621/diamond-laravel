<?php
// Frontend
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Backend\AttributesController;
use App\Http\Controllers\Backend\AttributesvaluesController;
use App\Http\Controllers\Backend\BlogcategoriesController;
use App\Http\Controllers\Backend\BlogsController;
use App\Http\Controllers\Backend\BlogtagsController;
use App\Http\Controllers\Backend\BServicecategoriesController;
use App\Http\Controllers\Backend\BServicesController;
use App\Http\Controllers\Backend\BServicetagsController;
use App\Http\Controllers\Backend\CategorysController;
use App\Http\Controllers\Backend\CouponsController;
use App\Http\Controllers\Backend\CourseCategoriesController;

// Backend
use App\Http\Controllers\Backend\CourseController as BackendCourseController;
use App\Http\Controllers\Backend\CourseLessonsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DiamondsController;
use App\Http\Controllers\Backend\FileManagerController;
use App\Http\Controllers\Backend\MaterialsController;
use App\Http\Controllers\Backend\MaterialTypesController;
use App\Http\Controllers\Backend\MembershipsController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProductMaterialsController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Backend\ProducttagsController;
use App\Http\Controllers\Backend\SettingGeneralController;
use App\Http\Controllers\Backend\ShippingOptionController;
use App\Http\Controllers\Backend\StepGroupsController;
use App\Http\Controllers\Backend\StepsController;
use App\Http\Controllers\Backend\TaxOptionController;
use App\Http\Controllers\Backend\UploadController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\VendorsController;
use App\Http\Controllers\Backend\WithdrawController;
use App\Http\Controllers\BlogController;
// seller register
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FFileManagerController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;


// notification
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

// Backend
Route::group(['prefix' => 'backend', 'as' => 'backend.', 'middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix' => 'setting'], function () {
        // tax
        Route::resource('/tax', TaxOptionController::class);
        // // shipping
        Route::resource('/shipping', ShippingOptionController::class);
        // // // general
        Route::resource('/general', SettingGeneralController::class);
    });
    // page
    Route::resource('/page', PageController::class);

    //uploads
    Route::group(['prefix' => 'filemanager', 'as' => 'filemanager.'], function () {
        Route::get('/', [UploadController::class, 'index'])->name('list');
        Route::middleware('optimizeImages')->group(function () {
            // all images will be optimized automatically
            // Route::post('upload-images', 'UploadController@index');
            Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
            Route::post('/ajaxupload', [UploadController::class, 'ajaxupload'])->name('ajaxupload');
            Route::post('/store', [UploadController::class, 'store'])->name('store');
        });
        // Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
        Route::get('/get_filemanager', [UploadController::class, 'get_filemanager'])->name('get_filemanager');
        Route::get('/files', [UploadController::class, 'getUploadedFile'])->name('getUploadedFile');
        Route::put('/update/{product}', [UploadController::class, 'update'])->name('update');
        Route::get('/get', [UploadController::class, 'get'])->name('get');
        Route::get('/getUploadedAssetsId', [UploadController::class, 'getUploadedAssetsId'])->name('getUploadedAssetsId');
    });

    Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
        Route::get('/', [FileManagerController::class, 'index'])->name('index');
        Route::get('/show', [FileManagerController::class, 'show'])->withoutMiddleware(['admin'])->name('show');
        Route::post('/store', [FileManagerController::class, 'store'])->name('store');
        Route::post('/destroy/{id}', [FileManagerController::class, 'destroy'])->name('destroy');
    });

    //products routes
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [ProductsController::class, 'index'])->name('list');
        Route::get('/pending', [ProductsController::class, 'pending'])->name('pending.list');
        Route::get('/edit_pending', [ProductsController::class, 'editPendingShow'])->name('edit_pending.list');
        Route::get('/edit_pending/edit/{id}', [ProductsController::class, 'pendingEdit'])->name('edit_pending.edit');
        Route::put('/edit_pending/update/{id}', [ProductsController::class, 'pendingUpdate'])->name('edit_pending.update');
        Route::get('/active', [ProductsController::class, 'active'])->name('active.list');
        Route::get('/archive', [ProductsController::class, 'archive'])->name('archive');
        Route::get('/archive/recover/{id}', [ProductsController::class, 'recover'])->name('recover');
        Route::get('/create', [ProductsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [ProductsController::class, 'update'])->name('update');
        Route::post('/store', [ProductsController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [ProductsController::class, 'destroy'])->name('delete');
        Route::get('/get', [ProductsController::class, 'get'])->name('get');
        Route::put('/update_digital_assets/{id}', [ProductsController::class, 'update_digital_assets'])->name('update_digital_assets');
        Route::put('/update_variant_assets/{id}', [ProductsController::class, 'update_variant_assets'])->name('update_variant_assets');

        Route::get('/product_materials/{id}', [ProductsController::class, 'product_materials'])->name('product_materials');
        Route::post('/update_product_materials', [ProductsController::class, 'update_product_materials'])->name('update_product_materials');
    });

    //users routes
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('list');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [UsersController::class, 'update'])->name('update');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::get('/get', [UsersController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('/', [UsersController::class, 'customers'])->name('list');
    });

    //categories routes
    Route::group(['prefix' => 'products/categories', 'as' => 'products.categories.'], function () {
        Route::get('/', [CategorysController::class, 'index'])->name('list');
        Route::get('/create', [CategorysController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [CategorysController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [CategorysController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CategorysController::class, 'destroy'])->name('delete');
        Route::post('/store', [CategorysController::class, 'store'])->name('store');
        Route::get('/get', [CategorysController::class, 'get'])->name('get');
    });

    //attributes routes
    Route::group(['prefix' => 'products/attributes', 'as' => 'products.attributes.'], function () {
        Route::get('/', [AttributesController::class, 'index'])->name('list');
        Route::get('/create', [AttributesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AttributesController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [AttributesController::class, 'update'])->name('update');
        Route::post('/store', [AttributesController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [AttributesController::class, 'destroy'])->name('delete');
        Route::post('/get_for_variants', [AttributesController::class, 'ajaxcall'])->withoutMiddleware(['admin'])->name('ajaxcall');
        Route::post('/get_combinations', [AttributesController::class, 'combinations'])->withoutMiddleware(['admin'])->name('combinations');
        Route::get('/get', [AttributesController::class, 'get'])->name('get');
        Route::post('/get/values', [AttributesController::class, 'getvalues'])->name('getvalues');
        Route::get('/get_product_attribute', [AttributesController::class, 'getProductAttribute'])->name('getproductattribute');
    });

    Route::group(['prefix' => 'products/attributes/{id_attribute}/values', 'as' => 'products.attributes.values.'], function () {
        Route::get('/', [AttributesvaluesController::class, 'index'])->name('list');
        Route::get('/create', [AttributesvaluesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AttributesvaluesController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AttributesvaluesController::class, 'update'])->name('update');
        Route::post('/store', [AttributesvaluesController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [AttributesvaluesController::class, 'destroy'])->name('delete');
        Route::get('/get', [AttributesvaluesController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'sellers', 'as' => 'sellers.'], function () {
        Route::get('/', [VendorsController::class, 'index'])->name('list');
        Route::get('/create', [VendorsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [VendorsController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [VendorsController::class, 'update'])->name('update');
        Route::post('/store', [VendorsController::class, 'store'])->name('store');
        Route::get('/get', [VendorsController::class, 'get'])->name('get');
    });
    //services routes
    Route::group(['prefix' => 'service/services', 'as' => 'services.'], function () {
        Route::get('/', [BServicesController::class, 'index'])->name('list');
        Route::get('/archive', [BServicesController::class, 'archive'])->name('archive');
        Route::get('/archive/recover/{id}', [BServicesController::class, 'recover'])->name('recover');
        Route::get('/create/{step?}/{post_id?}', [BServicesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BServicesController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [BServicesController::class, 'update'])->name('update');
        Route::post('/store', [BServicesController::class, 'store'])->name('store');
        Route::post('/package', [BServicesController::class, 'package'])->name('package');
        Route::get('/delete/{id}', [BServicesController::class, 'destroy'])->name('delete');
        Route::get('/get', [BServicesController::class, 'get'])->name('get');
    });

    //services routes
    Route::group(['prefix' => 'service/categories', 'as' => 'service.categories.'], function () {
        Route::get('/', [BServicecategoriesController::class, 'index'])->name('list');
        Route::get('/create', [BServicecategoriesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BServicecategoriesController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [BServicecategoriesController::class, 'destroy'])->name('delete');
        Route::put('/update/{product}', [BServicecategoriesController::class, 'update'])->name('update');
        Route::post('/store', [BServicecategoriesController::class, 'store'])->name('store');
        Route::get('/get', [BServicecategoriesController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'service/tags', 'as' => 'service.tags.'], function () {
        Route::get('/', [BServicetagsController::class, 'index'])->name('list');
        Route::get('/create', [BServicetagsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BServicetagsController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [BServicetagsController::class, 'destroy'])->name('delete');
        Route::put('/update/{product}', [BServicetagsController::class, 'update'])->name('update');
        Route::post('/store', [BServicetagsController::class, 'store'])->name('store');
        Route::get('/get', [BServicetagsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'memberships', 'as' => 'memberships.'], function () {
        Route::get('/', [MembershipsController::class, 'index'])->name('list');
        Route::get('/create', [MembershipsController::class, 'create'])->name('create');
        Route::get('/edit/{membership}', [MembershipsController::class, 'edit'])->name('edit');
        Route::put('/update/{membership}', [MembershipsController::class, 'update'])->name('update');
        Route::post('/store', [MembershipsController::class, 'store'])->name('store');
        Route::get('/delete/{membership}', [MembershipsController::class, 'destroy'])->name('delete');
        Route::get('/get', [MembershipsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'coupons', 'as' => 'coupons.'], function () {
        Route::get('/', [CouponsController::class, 'index'])->name('list');
        Route::get('/create', [CouponsController::class, 'create'])->name('create');
        Route::get('/edit/{coupon}', [CouponsController::class, 'edit'])->name('edit');
        Route::put('/update/{coupon}', [CouponsController::class, 'update'])->name('update');
        Route::post('/store', [CouponsController::class, 'store'])->name('store');
        Route::get('/delete/{coupon}', [CouponsController::class, 'destroy'])->name('delete');
        Route::get('/get', [CouponsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'step', 'as' => 'steps.'], function () {
        Route::get('/', [StepsController::class, 'index'])->name('list');
        Route::get('/create', [StepsController::class, 'create'])->name('create');
        Route::get('/edit/{step}', [StepsController::class, 'edit'])->name('edit');
        Route::put('/update/{step}', [StepsController::class, 'update'])->name('update');
        Route::post('/store', [StepsController::class, 'store'])->name('store');
        Route::get('/delete/{step}', [StepsController::class, 'destroy'])->name('delete');
        Route::get('/get', [StepsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'step_group', 'as' => 'step_groups.'], function () {
        Route::get('/', [StepGroupsController::class, 'index'])->name('list');
        Route::get('/create', [StepGroupsController::class, 'create'])->name('create');
        Route::get('/edit/{step_group}', [StepGroupsController::class, 'edit'])->name('edit');
        Route::put('/update/{step_group}', [StepGroupsController::class, 'update'])->name('update');
        Route::post('/store', [StepGroupsController::class, 'store'])->name('store');
        Route::get('/delete/{step_group}', [StepGroupsController::class, 'destroy'])->name('delete');
        Route::get('/get', [StepGroupsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'material', 'as' => 'materials.'], function () {
        Route::get('/', [MaterialsController::class, 'index'])->name('list');
        Route::get('/create', [MaterialsController::class, 'create'])->name('create');
        Route::get('/edit/{material}', [MaterialsController::class, 'edit'])->name('edit');
        Route::put('/update/{material}', [MaterialsController::class, 'update'])->name('update');
        Route::post('/store', [MaterialsController::class, 'store'])->name('store');
        Route::get('/delete/{material}', [MaterialsController::class, 'destroy'])->name('delete');
        Route::get('/get', [MaterialsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'measurements', 'as' => 'measurements.'], function() {
        Route::get('/', ['App\Http\Controllers\Backend\MeasurementController', 'index'])->name('list');
        Route::get('/get', ['App\Http\Controllers\Backend\MeasurementController', 'get'])->name('get');
        Route::get('/create', ['App\Http\Controllers\Backend\MeasurementController', 'create'])->name('create');
        Route::post('/store', ['App\Http\Controllers\Backend\MeasurementController', 'store'])->name('store');
        Route::get('/edit/{id}', ['App\Http\Controllers\Backend\MeasurementController', 'edit'])->name('edit');
        Route::post('/update', ['App\Http\Controllers\Backend\MeasurementController', 'update'])->name('update');
        Route::get('/delete/{id}', ['App\Http\Controllers\Backend\MeasurementController', 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'diamond', 'as' => 'diamonds.'], function () {
        Route::get('/', [DiamondsController::class, 'index'])->name('list');
        Route::get('/create', [DiamondsController::class, 'create'])->name('create');
        Route::get('/edit/{diamond}', [DiamondsController::class, 'edit'])->name('edit');
        Route::put('/update/{diamond}', [DiamondsController::class, 'update'])->name('update');
        Route::post('/store', [DiamondsController::class, 'store'])->name('store');
        Route::get('/delete/{diamond}', [DiamondsController::class, 'destroy'])->name('delete');
        Route::get('/get', [DiamondsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'material_type', 'as' => 'material_types.'], function () {
        Route::get('/', [MaterialTypesController::class, 'index'])->name('list');
        Route::get('/create', [MaterialTypesController::class, 'create'])->name('create');
        Route::get('/edit/{material_type}', [MaterialTypesController::class, 'edit'])->name('edit');
        Route::put('/update/{material_type}', [MaterialTypesController::class, 'update'])->name('update');
        Route::post('/store', [MaterialTypesController::class, 'store'])->name('store');
        Route::get('/delete/{material_type}', [MaterialTypesController::class, 'destroy'])->name('delete');
        Route::get('/get', [MaterialTypesController::class, 'get'])->name('get');
    });

    //posts routes
    Route::group(['prefix' => 'blog/posts', 'as' => 'posts.'], function () {
        Route::get('/', [BlogsController::class, 'index'])->name('list');
        Route::get('/trash', [BlogsController::class, 'trash'])->name('trash');
        Route::get('/trash/recover/{id}', [BlogsController::class, 'recover'])->name('recover');
        Route::get('/create', [BlogsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BlogsController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [BlogsController::class, 'update'])->name('update');
        Route::post('/store', [BlogsController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [BlogsController::class, 'destroy'])->name('delete');
        Route::get('/get', [BlogsController::class, 'get'])->name('get');
    });

    //posts routes
    Route::group(['prefix' => 'blog/categories', 'as' => 'blog.categories.'], function () {
        Route::get('/', [BlogcategoriesController::class, 'index'])->name('list');
        Route::get('/create', [BlogcategoriesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BlogcategoriesController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [BlogcategoriesController::class, 'destroy'])->name('delete');
        Route::put('/update/{product}', [BlogcategoriesController::class, 'update'])->name('update');
        Route::post('/store', [BlogcategoriesController::class, 'store'])->name('store');
        Route::get('/get', [BlogcategoriesController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'blog/tags', 'as' => 'blog.tags.'], function () {
        Route::get('/', [BlogtagsController::class, 'index'])->name('list');
        Route::get('/create', [BlogtagsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BlogtagsController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [BlogtagsController::class, 'destroy'])->name('delete');
        Route::put('/update/{product}', [BlogtagsController::class, 'update'])->name('update');
        Route::post('/store', [BlogtagsController::class, 'store'])->name('store');
        Route::get('/get', [BlogtagsController::class, 'get'])->name('get');
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////
    // Courses Routes
    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
        Route::get('/', [BackendCourseController::class, 'index'])->name('list');
        Route::get('/create', [BackendCourseController::class, 'create'])->name('create');
        Route::post('/store', [BackendCourseController::class, 'store'])->name('store');
        Route::get('/edit/{course}', [BackendCourseController::class, 'edit'])->name('edit');
        Route::put('/update/{course}', [BackendCourseController::class, 'update'])->name('update');
        Route::get('/delete/{course}', [BackendCourseController::class, 'destroy'])->name('delete');
        Route::get('/get', [BackendCourseController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'courses/categories', 'as' => 'courses.categories.'], function () {
        Route::get('/', [CourseCategoriesController::class, 'index'])->name('list');
        Route::get('/create', [CourseCategoriesController::class, 'create'])->name('create');
        Route::post('/store', [CourseCategoriesController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [CourseCategoriesController::class, 'edit'])->name('edit');
        Route::put('/update/{category}', [CourseCategoriesController::class, 'update'])->name('update');
        Route::get('/delete/{category}', [CourseCategoriesController::class, 'destroy'])->name('delete');
        Route::get('/get', [CourseCategoriesController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'courses/lessons', 'as' => 'courses.lessons.'], function () {
        Route::post('/store', [CourseLessonsController::class, 'store'])->name('store');
        Route::put('/update', [CourseLessonsController::class, 'update'])->name('update');
        Route::delete('/delete', [CourseLessonsController::class, 'destroy'])->name('delete');

        Route::post('/store_content', [CourseLessonsController::class, 'store_content'])->name('store_content');
        Route::put('/update_content', [CourseLessonsController::class, 'update_content'])->name('update_content');
        Route::delete('/delete_content', [CourseLessonsController::class, 'destroy_content'])->name('delete_content');
    });
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////

    Route::group(['prefix' => 'products/tags', 'as' => 'products.tags.'], function () {
        Route::get('/', [ProducttagsController::class, 'index'])->name('list');
        Route::get('/create', [ProducttagsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProducttagsController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [ProducttagsController::class, 'destroy'])->name('delete');
        Route::put('/update/{product}', [ProducttagsController::class, 'update'])->name('update');
        Route::post('/store', [ProducttagsController::class, 'store'])->name('store');
        Route::get('/get', [ProducttagsController::class, 'get'])->name('get');
    });

    Route::group(['prefix' => 'products/materials', 'as' => 'products.materials.'], function () {
        Route::post('/store', [ProductMaterialsController::class, 'store'])->name('store');
        Route::put('/update', [ProductMaterialsController::class, 'update'])->name('update');
        Route::delete('/delete', [ProductMaterialsController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', [BackendOrderController::class, 'index'])->name('list');
        Route::post('/', [BackendOrderController::class, 'pending_badge'])->name('pending_badge_get');
        Route::put('/status_tracking/{id}', [BackendOrderController::class, 'status_tracking_set'])->name('status_tracking');
        Route::get('/show/{id}', [BackendOrderController::class, 'show'])->name('show');
        Route::put('/item/{id}', [BackendOrderController::class, 'update'])->name('update');
        Route::get('/pending', [BackendOrderController::class, 'pending'])->name('pending');
        Route::post('/mark_as_canceled', [BackendOrderController::class, 'mark_as_canceled'])->name('mark_as_canceled');
        Route::post('/mark_as_chargeback', [BackendOrderController::class, 'mark_as_chargeback'])->name('mark_as_chargeback');
    });

    Route::group(['prefix' => 'withdraws', 'as' => 'withdraws.'], function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('list');
        Route::get('/method', [WithdrawController::class, 'methods'])->name('method');
        Route::get('/method/edit/{id}', [WithdrawController::class, 'methods_edit_get'])->name('method.edit');
        Route::post('/method/edit/{id}', [WithdrawController::class, 'methods_edit_post'])->name('method.edit_post');
        Route::get('/method/add', [WithdrawController::class, 'methods_add_get'])->name('method.add');
        Route::post('/method/add', [WithdrawController::class, 'methods_add_post'])->name('method.add_post');
        Route::get('/method/{id}', [WithdrawController::class, 'methods_delete'])->name('method.delete');

        Route::get('/status/pending/{id}', [WithdrawController::class, 'set_pending'])->name('status.pending');
        Route::get('/status/finished/{id}', [WithdrawController::class, 'set_finished'])->name('status.finished');
        Route::get('/status/rejected/{id}', [WithdrawController::class, 'set_rejected'])->name('status.rejected');
    });

    Route::get('/', [DashboardController::class, 'index'])->name('login');
});
// End Backend

// Homepage
Route::get('/', [AppController::class, 'index'])->name('index');

// Seller Profile
Route::get('/u/{username}', [SellerController::class, 'seller_profile'])->name('seller_profile');

Route::group(['middleware' => ['auth']], function () {
    // User Dashboard
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');

    Route::group(['controller' => NotificationController::class, 'prefix' => 'notifications', 'as' => 'notifications.'], function () {
        Route::get('/check/{id}', 'check')->name('check');
        Route::post('/overview', 'overview')->name('overview');
    });

    Route::post('/api-upload-file', [UploadController::class, 'apiUpload'])->name('api_upload');
    Route::get('/download-upload-file/{id}', [UploadController::class, 'downloadFile'])->name('download_file');
});

//services
Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
    Route::get('/', [ServicesController::class, 'all'])->name('all');
    Route::get('/dashboard', [ServicesController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [ServicesController::class, 'orders'])->name('orders');
    Route::post('/order/complete', [ServicesController::class, 'order_complete'])->name('order_complete');
    Route::post('/order/revision', [ServicesController::class, 'order_revision'])->name('order_revision');
    Route::get('/order/{id}', [ServicesController::class, 'order_detail'])->name('order_detail');
    Route::get('/checkout/finish', [ServicesController::class, 'finish'])->name('finish');
    Route::post('/checkout/payment', [ServicesController::class, 'post_payment'])->name('payment.post');
    Route::delete('/checkout/cancel', [ServicesController::class, 'cancel'])->name('cancel');
    Route::post('/checkout/answer', [ServicesController::class, 'answer'])->name('answer');
    Route::post('/checkout/intent/{id}', [ServicesController::class, 'create_payment_intent'])->name('intent.post');
    Route::get('/checkout/payment/{id}', [ServicesController::class, 'get_payment'])->name('payment.get');
    Route::post('/checkout/store/{id}', [ServicesController::class, 'store_order'])->name('store');
    Route::get('/checkout/{id}', [ServicesController::class, 'get_billing'])->name('billing.get');
    Route::post('/checkout/{id}', [ServicesController::class, 'post_billing'])->name('billing.post');
    Route::get('/review/{id}', [ServicesController::class, 'service_review_get'])->name('review');
    Route::post('/review', [ServicesController::class, 'service_review_post'])->name('review.post');
    Route::get('/{slug}', [ServicesController::class, 'detail'])->name('detail');
});

// Seller Dashboard
Route::group(['middleware' => ['auth'], 'prefix' => 'seller', 'as' => 'seller.'], function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [SellerController::class, 'service_orders'])->name('service.orders');
    Route::get('/order_detail/{id}', [SellerController::class, 'service_order_detail'])->name('service.order.detail');
    Route::post('/order/deilver', [SellerController::class, 'service_order_deliver'])->name('service.order.deliver');
    Route::get('/transaction/history', [SellerController::class, 'transactionHistory'])->name('transaction.history');
    Route::get('/product/create', [SellerController::class, 'createProduct'])->name('product.create');
    Route::post('/product/create', [SellerController::class, 'storeProduct'])->name('product.store');
    Route::get('/product/edit/{id}', [SellerController::class, 'editProduct'])->name('product.edit');
    Route::put('/product/update/{product}', [SellerController::class, 'updateProduct'])->name('product.update');
    Route::get('/withdraw', [SellerController::class, 'withdraw'])->name('withdraw.get');
    Route::post('/withdraw', [SellerController::class, 'withdraw_post'])->name('withdraw.post');
    Route::get('/withdraw/history', [SellerController::class, 'withdraw_history'])->name('withdraw.history');
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::post('/profile', [SellerController::class, 'save_profile'])->name('profile.post');

    Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
        Route::get('/', [FFileManagerController::class, 'index'])->name('index');
        Route::get('/show', [FFileManagerController::class, 'show'])->name('show');
        Route::post('/store', [FFileManagerController::class, 'store'])->name('store');
        Route::post('/store_image', [FFileManagerController::class, 'store_origin_image'])->name('image');
        Route::post('/store_thumb', [FFileManagerController::class, 'store_thumb_image'])->name('thumb');
        Route::post('/destroy/{id}', [FFileManagerController::class, 'destroy'])->name('destroy');
    });

    //services routes
    Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
        Route::get('/', [ServicesController::class, 'index'])->name('list');
        Route::get('/trash', [ServicesController::class, 'trash'])->name('trash');
        Route::get('/trash/recover/{id}', [ServicesController::class, 'recover'])->name('recover');
        Route::get('/create/{step?}/{post_id?}', [ServicesController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [ServicesController::class, 'update'])->name('update');
        Route::post('/store', [ServicesController::class, 'store'])->name('store');
        Route::post('/gallery', [ServicesController::class, 'gallery'])->name('gallery');
        Route::post('/package', [ServicesController::class, 'package'])->name('package');
        Route::post('/requirement', [ServicesController::class, 'requirement'])->name('requirement');
        Route::post('/review', [ServicesController::class, 'review'])->name('review');
        Route::get('/delete/{id}', [ServicesController::class, 'destroy'])->name('delete');
        Route::get('/get', [ServicesController::class, 'get'])->name('get');
    });

});

Route::get('/image/{filename}', [AppController::class, 'image']);

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.post.url');
Route::get('/blog/archives/category/', [BlogController::class, 'categoryAll'])->name('categoryAll');
Route::get('/blog/category/{category}', [BlogController::class, 'categoryPost'])->name('categoryPost');
Route::get('/blog/archives/tag/', [BlogController::class, 'tagAll'])->name('tagAll');
Route::get('/blog/tag/{tag}', [BlogController::class, 'tagPost'])->name('tagPost');

// Search
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/searchCategory', [ProductController::class, 'searchCategory'])->name('searchCategory');
Route::get('/filter-product', [ProductController::class, 'filterProduct'])->name('filter.product');

// Products
Route::middleware(['auth', 'admin'])->resource('products', ProductController::class)->except(['index', 'show']);
Route::get('p/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products/add_review', [ProductController::class, 'addReview'])->name('products.add_review');

// Memberships
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');

// Products Shop Page
Route::get('/3d-models', [ProductController::class, 'products_index'])->name('shop_index');

// Cart
Route::group(['controller' => CartController::class, 'prefix' => 'cart', 'as' => 'cart.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::middleware('verified')->post('/buy-now', 'buyNow')->name('buy.now');

    });
    Route::get('/count', 'getCount')->name('count');
    Route::post('/edit', 'editQty')->name('edit.qty');
    Route::get('/remove/{id}', 'removeProduct')->name('remove.product');
});

// Course
Route::group(['controller' => CourseController::class, 'prefix' => 'courses', 'as' => 'courses.'], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/checkout/finish', 'finish')->name('finish');
        Route::post('/checkout/payment', 'post_payment')->name('payment.post');
        Route::delete('/checkout/cancel', 'cancel')->name('cancel');
        Route::post('/checkout/answer', 'answer')->name('answer');
        Route::post('/checkout/intent/{id}', 'create_payment_intent')->name('intent.post');
        Route::get('/checkout/payment/{id}', 'get_payment')->name('payment.get');
        Route::post('/checkout/store/{id}', 'store_order')->name('store');
        Route::get('/checkout/{id}', 'get_billing')->name('billing.get');
        Route::post('/checkout/{id}', 'post_billing')->name('billing.post');
        Route::get('/take/{slug}', 'take_show')->name('take');
        Route::get('/take/complete/{id}', 'complete_lesson')->name(('complete'));
    });
    Route::get('/', 'index')->name('index');
    Route::get('/orders', 'orders')->name('orders');
    Route::get('/order/{id}', 'order_detail')->name('order_detail');
    Route::get('/category/{slug}', 'category')->name('category');
    Route::get('/course/{slug}', 'show')->name('show');

});

Route::group(['controller' => CartController::class], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'wishlist', 'as' => 'wishlist'], function () {
            Route::get('/', 'wishlist');
            Route::post('/', 'wishlistStore');
            Route::put('/', 'wishlistToCart');
            Route::delete('/', 'removeFromWishlist');
        });
             //chat routes
     Route::get('/chat', [ChatController::class, 'create'])->name('chat');
     Route::get('/chat/getChatContent', [ChatController::class, 'contentFetchByClientId'])->name('chat.clientId');
     Route::get('/chat/filter', [ChatController::class, 'filter'])->name('chat.filter');

     Route::get('/chat/{conversation_id}',[ChatController::class, 'create_chat_room'])->name('create_chat_room');
     Route::post('/chat/message_log',[ChatController::class, 'message_log'])->name('chat.message_log');
     Route::post('/chat/information',[ChatController::class, 'getChatInFormationBy'])->name('chat.information');

    });
});

Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);

// Auth
Route::group(['middleware' => 'auth'], function () {

    Route::get('/product_download/{order_id}/{upload_id}', [ProductController::class, 'download'])->name('download');
    Route::get('/product_download', [ProductController::class, 'download'])->name('download');

    Route::group(['prefix' => 'email/verify', 'as' => 'verification.', 'controller' => VerifyEmailController::class], function () {
        Route::get('/', 'emailVerificationNotice')->name('notice');
        Route::get('/{id}/{hash}', 'verificationHandler')->middleware('signed')->name('verify');
    });
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    Route::group(['prefix' => 'payment', 'as' => 'checkout.', 'controller' => CheckoutController::class], function () {
        Route::get('/finished', 'paymentFinished')->name('finished');
        Route::delete('/cancel', 'cancel')->name('cancel');
    });

    // Route::group(['middleware' => ['checkout', 'verified']], function ()
    // });
    Route::resource('checkout', CheckoutController::class)->only(['index', 'store']);
    Route::post('/payment/intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.payment.intent');
    Route::get('checkout/shipping', [CheckoutController::class, 'getShipping'])->name('checkout.shipping.get');
    Route::post('checkout/shipping', [CheckoutController::class, 'postShipping'])->name('checkout.shipping.post');
    Route::get('checkout/billing', [CheckoutController::class, 'getBilling'])->name('checkout.billing.get');
    Route::post('checkout/billing', [CheckoutController::class, 'postBilling'])->name('checkout.billing.post');
    Route::get('checkout/payment', [CheckoutController::class, 'getPayment'])->name('checkout.payment.get');
    Route::post('checkout/payment', [CheckoutController::class, 'postPayment'])->name('checkout.payment.post');
    Route::post('checkout/check_coupon', [CheckoutController::class, 'checkCoupon'])->name('checkout.check_coupon');

    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    Route::group(['prefix' => 'user', 'as' => 'user.', 'controller' => UserController::class], function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/edit/password', 'editPassword')->name('edit.password');
        Route::patch('/edit/password', 'updatePassword')->name('update.password');
        Route::put('/edit/account', 'update_account')->name('update.account');
        Route::put('/edit/address', 'update_address')->name('update.address');
        Route::delete('/delete', 'delete')->name('delete');
        Route::post('/disable', 'disable')->name('disable');
        Route::get('/{id_user}', 'index')->name('index');
    });
});

// contact

Route::prefix('contact-us')->name('contactus.')->controller(\App\Http\Controllers\ContactController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

// track order page
Route::get('trackorder', [OrderController::class, 'trackOrder'])->name('track.order');
Route::get('seller/signup', [SellerRegisterController::class, 'create'])->name('seller.signup.create');
Route::post('seller/signup', [SellerRegisterController::class, 'store'])->name('seller.signup.store');
// seller signup

require __DIR__ . '/auth.php';

Route::get('{slug?}', UriController::class)->name('page')->where('slug', '.+');
