<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Budget\Http\Controllers\BudgetController;
use Modules\Budget\Http\Controllers\CardController;
use Modules\Budget\Http\Controllers\CategoryController;


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

Route::group(['middleware' => ['cors', 'json.response']], function () {

});

Route::middleware('auth:api')->get('/authorized', function () {
    dd('Authorized!');
});


Route::namespace('\\')->middleware('auth:api')->group(function () {
    Route::get('/chart/donut', [BudgetController::class, 'getDataForDonutChart']);

    Route::get('/categories/all', [CategoryController::class, 'getCategories']);
    Route::get('/categories/names', [CategoryController::class, 'getCategoriesNames']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/images', [CardController::class, 'getImages']);
    Route::post('/images', [CardController::class, 'storeImages']);
    Route::get('/cards/sorted', [CardController::class, 'sortedCards']);
    Route::resource('budget', BudgetController::class);
    Route::resource('cards', CardController::class);
});
