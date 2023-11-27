<?php

use App\Http\Controllers\API\Auth\AuthAPIController;
use App\Http\Controllers\API\AuthorAPIController;
use App\Http\Controllers\API\BookAPIController;
use App\Http\Controllers\API\BookRentAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\RoleAPIController;
use App\Http\Controllers\API\UserAPIController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthAPIController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::get('profile', 'profile');
});


Route::middleware('auth:api')->group(function () {

    Route::prefix('user')->group(function () {
        Route::controller(UserAPIController::class)->group(function () {
            Route::post('/edit/{user}', 'update')->middleware('check.access:user-edit');
            Route::post('/delete/{user}', 'destroy')->middleware('check.access:user-delete');
        });
    });

    Route::prefix('role')->group(function () {
        Route::controller(RoleAPIController::class)->group(function () {
            Route::get('/list', 'index')->middleware('check.access:role-list');
            Route::post('/create', 'store')->middleware('check.access:role-create');
            Route::post('/edit/{role}', 'update')->middleware('check.access:role-edit');
        });
    });

    Route::prefix('author')->group(function () {
        Route::controller(AuthorAPIController::class)->group(function () {
            Route::get('/list', 'index')->middleware('check.access:author-list');
            Route::post('/create', 'store')->middleware('check.access:author-create');
            Route::post('/edit/{author}', 'update')->middleware('check.access:author-edit');
            Route::post('/delete/{author}', 'destroy')->middleware('check.access:author-delete');
        });
    });

    Route::prefix('category')->group(function () {
        Route::controller(CategoryAPIController::class)->group(function () {
            Route::get('/list', 'index')->middleware('check.access:category-list');
            Route::post('/create', 'store')->middleware('check.access:category-create');
            Route::post('/edit/{category}', 'update')->middleware('check.access:category-edit');
            Route::post('/delete/{category}', 'destroy')->middleware('check.access:category-delete');
        });
    });

    Route::prefix('book')->group(function () {
        Route::controller(BookAPIController::class)->group(function () {
            Route::get('/list', 'index')->middleware('check.access:book-list');
            Route::post('/create', 'store')->middleware('check.access:book-create');
            Route::post('/edit/{book}', 'update')->middleware('check.access:book-edit');
            Route::post('/delete/{book}', 'destroy')->middleware('check.access:book-delete');
        });
    });

    Route::prefix('bookrent')->group(function () {
        Route::controller(BookRentAPIController::class)->group(function () {
            Route::post('/create', 'store')->middleware('check.access:rent-create');
        });
    });
});
