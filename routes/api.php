<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::post('/users', [ApiUserController::class, 'store'])->name('users.store');
    Route::post('/login', [ApiUserController::class, 'login'])->name('users.login');
    ROute::middleware('auth:sanctum')->group(function(){
        Route::post('/logout', [ApiUserController::class, 'logout'])->name('users.logout');
        Route::get('/users/{id}', [ApiUserController::class, 'show'])->name('users.show');
        // Route::put('/users/{id}', [ApiUserController::class, 'update'])->name('users.update');
        // Route::delete('/users/{id}', [ApiUserController::class, 'destroy'])->name('users.destroy');
    });
});
