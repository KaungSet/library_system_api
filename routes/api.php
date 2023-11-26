<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthorAPIController;
use App\Http\Controllers\API\RegisterController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::get('profile', [AuthController::class, 'profile']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('author')->group(function () {
        Route::controller(AuthorAPIController::class)->group(function () {
            Route::get('/list', 'index');
        });
    });
});

