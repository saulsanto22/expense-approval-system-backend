<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApprovalStageController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ApproverController;

Route::prefix('approvers')->group(function () {
    Route::post('/', ApproverController::class)->name('approvers.store');
});

Route::prefix('approval-stages')->group(function () {
    Route::post('/', [ApprovalStageController::class, 'store'])->name('approval-stages.store');
});

Route::prefix('expenses')->group(function () {
    Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::patch('/{id}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::get('/detail/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
});
