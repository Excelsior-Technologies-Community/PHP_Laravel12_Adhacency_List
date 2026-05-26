<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/store', [CategoryController::class, 'store']);

// ✏️ Edit & Update Category
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
Route::post('/categories/update/{id}', [CategoryController::class, 'update']);

// ✋ Drag and Drop Move (API)
Route::post('/categories/move', [CategoryController::class, 'move']);

Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/trash', [CategoryController::class, 'trash']);
Route::get('/categories/restore/{id}', [CategoryController::class, 'restore']);

Route::get('/categories/toggle/{id}', [CategoryController::class, 'toggle']);