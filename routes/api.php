<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ExpenseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/approvers', [ApproverController::class, 'store']);

Route::prefix('approval-stages')->group(function () {
    Route::post('/', [ApprovalStageController::class, 'store']);
    Route::put('/{id}', [ApprovalStageController::class, 'update']);
});

Route::prefix('expense')->group(function(){
    Route::post('/', [ExpenseController::class, 'store']);
    Route::patch('/{id}/approve', [ExpenseController::class, 'approve']);
    Route::get('/{id}', [ExpenseController::class, 'show']);
});





