<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\CourtTypeController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//api route public
Route::post("auth/login",[AuthController::class,'login']);
Route::apiResource("auth", AuthController::class);
Route::apiResource("servicetypes", ServiceTypeController::class);
    Route::apiResource("services", ServiceController::class);
    Route::apiResource("courttypes", CourtTypeController::class);
    Route::apiResource("courts", CourtController::class);
    Route::apiResource("casetypes", CaseTypeController::class);
    Route::apiResource("cases", CasesController::class);
    Route::apiResource("customers", CustomerController::class);
    Route::patch('/customers/restore/{id}', [CustomerController::class, 'restore']);
//api route private
Route::middleware(['auth:api'])->group(function () {
    
});
