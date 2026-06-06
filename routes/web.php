<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ThreadController as FrontThreadController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController as BackUserController;
use App\Http\Controllers\Backend\ThreadController as BackThreadController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Frontend\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes (Web Prefix for Zero Config)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/categories', [ApiController::class, 'categories'])->name('categories');
    Route::get('/products', [ApiController::class, 'products'])->name('products');
    Route::get('/banners', [ApiController::class, 'banners'])->name('banners');
    Route::get('/pages', [ApiController::class, 'pages'])->name('pages');
});

/*
|--------------------------------------------------------------------------
| Storefront Product & Catalog Routes
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('shop.category');
Route::get('/product/{sku}', [ProductController::class, 'show'])->name('shop.product');

/*
|--------------------------------------------------------------------------
| Frontend User Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/threads', [FrontThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{id}', [FrontThreadController::class, 'show'])->name('threads.show');
Route::get('/pages/{slug}', [HomeController::class, 'showPage'])->name('pages.show');

/*
|--------------------------------------------------------------------------
| Backend Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('backend')->name('backend.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('backend')->name('backend.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    Route::get('/products', [AdminController::class, 'productsIndex'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productsCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productsStore'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productsEdit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productsUpdate'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productsDestroy'])->name('products.destroy');
    
    Route::get('/categories', [AdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'categoriesCreate'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'categoriesStore'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'categoriesEdit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'categoriesUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoriesDestroy'])->name('categories.destroy');
    
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    
    Route::get('/banners', [AdminController::class, 'bannersIndex'])->name('banners.index');
    Route::get('/banners/create', [AdminController::class, 'bannersCreate'])->name('banners.create');
    Route::post('/banners', [AdminController::class, 'bannersStore'])->name('banners.store');
    Route::get('/banners/{id}/edit', [AdminController::class, 'bannersEdit'])->name('banners.edit');
    Route::put('/banners/{id}', [AdminController::class, 'bannersUpdate'])->name('banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'bannersDestroy'])->name('banners.destroy');
    
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
    
    Route::get('/pages', [AdminController::class, 'pagesIndex'])->name('pages.index');
    Route::get('/pages/create', [AdminController::class, 'pagesCreate'])->name('pages.create');
    Route::post('/pages', [AdminController::class, 'pagesStore'])->name('pages.store');
    Route::get('/pages/{id}/edit', [AdminController::class, 'pagesEdit'])->name('pages.edit');
    Route::put('/pages/{id}', [AdminController::class, 'pagesUpdate'])->name('pages.update');
    Route::delete('/pages/{id}', [AdminController::class, 'pagesDestroy'])->name('pages.destroy');
    
    Route::get('/shipping', [AdminController::class, 'shipping'])->name('shipping');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
});


