<?php

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

Route::prefix('v1')->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('refresh-token', 'AuthController@refreshToken');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('test', function() {
            dd(2311);
        });
    });
});
