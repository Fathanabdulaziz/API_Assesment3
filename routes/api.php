<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TugasController;


Route::get('/tugas', [TugasController::class, 'index']);
Route::post('/tugas/store', [TugasController::class, 'store']);
Route::get('/tugas/{id}', [TugasController::class, 'show']);
Route::delete('/tugas/delete/{id}', [TugasController::class, 'destroy']);
Route::put('/tugas/update/{id}', [TugasController::class, 'update']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
