<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PurchaseController;
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

Route::middleware('api')->group(function () {
    /**
     * Api version 1.0
     */
    Route::prefix('v1')->group(function () {
        /**
         * Apps
         */
        Route::prefix('app')->group(function () {
            Route::post('/create', [AppController::class, 'store']);
            Route::put('/update/{id}', [AppController::class, 'update']);
            Route::post('/delete/{id}', [AppController::class, 'destroy']);
            Route::get('/show/{id}', [AppController::class, 'show']);
            Route::get('/list', [AppController::class, 'list']);
        });
        /**
         * Devices
         */
        Route::prefix('device')->group(function () {
            Route::post('/create', [DeviceController::class, 'store']);
            Route::put('/update/{id}', [DeviceController::class, 'update']);
            Route::post('/delete/{id}', [DeviceController::class, 'destroy']);
            Route::get('/show/{id}', [DeviceController::class, 'show']);
            Route::get('/list', [DeviceController::class, 'list']);
        });
        /**
         * Purchase
         */
        Route::prefix('purchase')->group(function () {
            Route::middleware('check.token')->group(function () {
                Route::post('/process', [PurchaseController::class, 'process']);
                Route::post('/check-subscription', [PurchaseController::class, 'check']);
            });
            Route::post('/delete/{id}', [PurchaseController::class, 'destroy']);
            Route::get('/show/{id}', [PurchaseController::class, 'show']);
            Route::get('/list', [PurchaseController::class, 'list']);
        });
    });
});
