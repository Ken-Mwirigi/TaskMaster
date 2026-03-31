<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::patch('{id}/status', [TaskController::class, 'updateStatus']);
    Route::delete('{id}', [TaskController::class, 'destroy']);
    Route::get('report', [TaskController::class, 'report']);
});