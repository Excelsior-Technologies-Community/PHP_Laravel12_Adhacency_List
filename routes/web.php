<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/create', [CategoryController::class, 'create']);
Route::post('/categories/store', [CategoryController::class, 'store']);

Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/trash', [CategoryController::class, 'trash']);
Route::get('/categories/restore/{id}', [CategoryController::class, 'restore']);

Route::get('/categories/toggle/{id}', [CategoryController::class, 'toggle']);