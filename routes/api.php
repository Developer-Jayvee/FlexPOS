<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ORController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix("v1")->group(function(){
    Route::apiResource("inventory",InventoryController::class);
    Route::apiResource("orders",OrdersController::class);

    Route::get('generateORNo',[ORController::class,'getORNo']);
    Route::get('generateNewOR',[ORController::class,'createNewOR']);
});
