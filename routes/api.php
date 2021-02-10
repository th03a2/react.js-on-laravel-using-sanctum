<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user();});

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/email/exist', [AuthController::class, 'exist']);
    Route::post('/forgot', [ForgotController::class, 'forgot']);
    Route::post('/reset', [ForgotController::class, 'reset']);
});

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/list', [UserController::class, 'list']);
        Route::post('/save', [UserController::class, 'save']);
        Route::put('/{user}/update', [UserController::class, 'update']);
        Route::post('/{user}/upload', [UserController::class, 'upload']);
        Route::delete('/{user}/destroy', [UserController::class, 'destroy']);
    });

  


});
