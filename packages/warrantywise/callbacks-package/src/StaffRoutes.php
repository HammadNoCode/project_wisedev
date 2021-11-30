<?php

use Illuminate\Support\Facades\Route;

use Callbacks\Http\Controllers\CallbacksController;


Route::group(['domain' => env('STAFF_URL')], function () {
	Route::group(['middleware' => ['web']], function () {
		Route::group(['middleware' => ['staff-logged-in']], function () {
			// API
			Route::prefix('api')->group(function () {
                Route::prefix('call-schedule')->group(function () {
                    Route::patch('create', [CallbacksController::class, 'store']);
                    Route::post('', [CallbacksController::class, 'index']);
					Route::patch('/{id}', [CallbacksController::class, 'update']);
					Route::post('overview', [CallbacksController::class, 'overview']);
                });
			});
		});
	});
});
