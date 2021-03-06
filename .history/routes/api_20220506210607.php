<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
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

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signin', [AuthController::class, 'sign']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('getuser', [AuthController::class, 'getUser']);
    });
