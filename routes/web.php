<?php

use App\Http\Controllers\CartController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UsersController;
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

Route::get('/', function () {
    return view("app");
});

// Route::get( '/cart', [ CartController::class, 'show' ] );
// Route::get( '/cart/update', [ CartController::class, 'UpdateCart' ] );
// Route::post( '/cart/update', [ CartController::class, 'UpdateCart' ] );

Route::get('/createdDev', [UsersController::class, 'createdDev']);

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
