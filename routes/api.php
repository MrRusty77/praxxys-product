<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
// use App\Http\Controllers\BlogsController;
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
    // Route::get('/users', [UsersController::class, 'search']);
    Route::get('/users/search', [UsersController::class, 'search']);
    Route::post('/users/search', [UsersController::class, 'search']);
    Route::post('/users/AddOrUpdate', [UsersController::class, 'AddOrUpdate']);
    Route::post('/users/remove', [UsersController::class, 'removeUser']);

    // Route::get('/cathegory', [CathegoriesController::class, 'search']);
    Route::get('/category/search', [CategoriesController::class, 'search']);
    Route::post('/category/search', [CategoriesController::class, 'search']);
    Route::post('/category/AddOrUpdate', [CategoriesController::class, 'AddOrUpdate']);
    Route::post('/category/remove', [CategoriesController::class, 'removeCategory']);

    // Route::get('/blogs', [BlogsController::class, 'search']);
    Route::get('/Product/search', [Product::class, 'search']);
    Route::post('/Product/AddOrUpdate', [Product::class, 'AddOrUpdate']);
    Route::post('/Product/uploadImg', [Product::class, 'uploadImg']);

});