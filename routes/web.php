<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view("app");
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/mayaPayment', [TransactionsController::class, 'mayaPayment']);

Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/dashboard/getNumbers', [DashboardController::class, 'getNumbers']);

        Route::get('/users', [UsersController::class, 'index']);
        Route::get('/users/search', [UsersController::class, 'search']);
        Route::post('/users/search', [UsersController::class, 'search']);
        Route::post('/users/AddOrUpdate', [UsersController::class, 'AddOrUpdate']);
        Route::post('/users/remove', [UsersController::class, 'removeUser']);
        Route::post('/users/checkUsername', [UsersController::class, 'checkUsername']);

        Route::get('/categories', [CategoriesController::class, 'index']);
        Route::get('/category/get', [CategoriesController::class, 'get']);
        Route::get('/category/search', [CategoriesController::class, 'search']);
        Route::post('/category/search', [CategoriesController::class, 'search']);
        Route::post('/category/AddOrUpdate', [CategoriesController::class, 'AddOrUpdate']);
        Route::post('/category/remove', [CategoriesController::class, 'removeCategory']);

        Route::get('/product', [ProductController::class, 'index']);
        Route::get('/product/show', [ProductController::class, 'show']);
        Route::post('/product/show', [ProductController::class, 'show']);
        Route::post('/product/AddOrUpdate', [ProductController::class, 'AddOrUpdate']);
        Route::post('/product/uploadImg', [ProductController::class, 'uploadImg']);
        Route::post('/product/remove', [ProductController::class, 'removeProduct']);

        Route::post('/images/get', [ImagesController::class, 'get']);

        Route::get('/catalogue', [ProductController::class, 'Catalogue']);

        Route::get('/cart', [CartController::class, 'index']);
        Route::get('/cart/search', [CartController::class, 'show']);
        Route::post('/cart/search', [CartController::class, 'show']);\
        Route::post('/cart/update', [CartController::class, 'updateCart']);
        Route::post('/cart/remove', [CartController::class, 'destroy']);
        
        Route::get('/transactions', [TransactionsController::class, 'index']);
        Route::get('/transactions/search', [TransactionsController::class, 'show']);
        Route::post('/transactions/search', [TransactionsController::class, 'show']);
        Route::put('/transactions', [TransactionsController::class, 'store']);
}
);


require __DIR__ . '/auth.php';
