<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/dashboard/getNumbers', [DashboardController::class, 'getNumbers']);

    // Route::get('/users', [UsersController::class, 'search']);
    Route::get('/users/search', [UsersController::class, 'search']);
    Route::post('/users/search', [UsersController::class, 'search']);
    Route::post('/users/AddOrUpdate', [UsersController::class, 'AddOrUpdate']);
    Route::post('/users/remove', [UsersController::class, 'removeUser']);
    Route::post('/users/checkUsername', [UsersController::class, 'checkUsername']);

    // Route::get('/cathegory', [CathegoriesController::class, 'search']);
    Route::get('/category/get', [CategoriesController::class, 'get']);
    Route::get('/category/search', [CategoriesController::class, 'search']);
    Route::post('/category/search', [CategoriesController::class, 'search']);
    Route::post('/category/AddOrUpdate', [CategoriesController::class, 'AddOrUpdate']);
    Route::post('/category/remove', [CategoriesController::class, 'removeCategory']);

    // Route::get('/blogs', [BlogsController::class, 'search']);
    Route::get('/product/show', [ProductController::class, 'show']);
    Route::post('/product/show', [ProductController::class, 'show']);
    Route::get('/product/search', [ProductController::class, 'search']);
    Route::post('/product/search', [ProductController::class, 'search']);
    Route::post('/product/AddOrUpdate', [ProductController::class, 'AddOrUpdate']);
    Route::post('/product/uploadImg', [ProductController::class, 'uploadImg']);
    Route::post('/product/remove', [ProductController::class, 'removeProduct']);


    Route::post('/images/get', [ImagesController::class, 'get']);

    Route::get('/cart/search', [CartController::class, 'show']);
    Route::post('/cart/search', [CartController::class, 'show']);\
    Route::post('/cart/update', [CartController::class, 'updateCart']);
    Route::post('/cart/remove', [CartController::class, 'destroy']);
    
    Route::get('/transaction', [TransactionsController::class, 'show']);
    Route::post('/transaction', [TransactionsController::class, 'show']);
    Route::put('/transaction', [TransactionsController::class, 'store']);

});