<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Savings\Http\Controllers\GoalsController;

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

Route::namespace('\\')->middleware('auth:api')->group(function () {
    Route::resource('goals', GoalsController::class);
});

Route::middleware('auth:api')->get('/savings', function (Request $request) {
    return $request->user();
});
