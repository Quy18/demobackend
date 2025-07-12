<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    Route::get('/login', [ApiUserController::class, 'index'])->name('users.index');
    Route::post('/users', [ApiUserController::class, 'store'])->name('users.store');
    Route::post('/login', [ApiUserController::class, 'login'])->name('users.login');
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/logout', [ApiUserController::class, 'logout'])->name('users.logout');
        Route::get('/users', [ApiUserController::class, 'show'])->name('users.show');
        Route::put('/users', [ApiUserController::class, 'update'])->name('users.update');
    });
    Route::get('/categories', [ApiCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{id}', [ApiCategoryController::class, 'showProductByCateId'])->name('categories.products');
});
