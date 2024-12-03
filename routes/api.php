<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TableController;
use App\Http\Controllers\api\MealController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ChechAvailableTableController;
use App\Http\Controllers\api\RreservationController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\CheckoutController;

Route::apiResource('/table',TableController::class);
Route::apiResource('/meals',MealController::class);




Route::get('/CheckTableAvailble',[ChechAvailableTableController::class,'CheckTableAvailble']);
Route::post('/register',[CustomerController::class,'register']);



Route::middleware(['auth:sanctum'])->group(function () {
 Route::post('/reserveTable',[ChechAvailableTableController::class,'reserveTable']);
 Route::post('/setorder',[OrderController::class,'setOrder']);
 Route::post('/Checkout',[CheckoutController::class,'Checkout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
