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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::get('/users', [UsersController::class, 'search']);
    Route::get('/users/search', [UsersController::class, 'search']);
    Route::post('/users/AddOrUpdate', [UsersController::class, 'AddOrUpdate']);

    // Route::get('/cathegory', [CathegoriesController::class, 'search']);
    Route::get('/cathegory/search', [CathegoriesController::class, 'search']);
    Route::post('/cathegory/search', [CathegoriesController::class, 'search']);
    Route::post('/cathegory/AddOrUpdate', [CathegoriesController::class, 'AddOrUpdate']);

    // Route::get('/blogs', [BlogsController::class, 'search']);
    Route::get('/Product/search', [Product::class, 'search']);
    Route::post('/Product/AddOrUpdate', [Product::class, 'AddOrUpdate']);
    Route::post('/Product/uploadImg', [Product::class, 'uploadImg']);

});