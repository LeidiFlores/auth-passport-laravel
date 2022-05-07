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

        Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
            Route::get('menus', [MenuController::class, 'index']);
            Route::post('menus', [MenuController::class, 'store']);
            Route::put('menus/{menu_id}', [MenuController::class, 'update']);

            Route::post('people', [PeopleController::class, 'index']);
            Route::get('people/show/{people}', [PeopleController::class, 'show']);
            Route::put('people/{people_id}', [PeopleController::class, 'update']);

            Route::post('roles/store', [RoleController::class,'store']);
            Route::post('roles/index', [RoleController::class,'index']);
            Route::put('roles/update/{id}', [RoleController::class,'update']);

            Route::get('document-type', [TypeDocumentController::class, 'index']);
            Route::get('document-type/show/{people}', [TypeDocumentController::class, 'show']);
            Route::put('document-type/{document_type_id}', [TypeDocumentController::class, 'update']);

            Route::resource('/country', CountryController::class);
            Route::resource('/state', StateController::class);
            Route::resource('/city', CityController::class);
            Route::resource('/company', CompanyController::class);
            Route::resource('/branch', BranchController::class);
        });
    });
