<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/product',[ProductController::class, 'index']);
Route::post('/product',[ProductController::class, 'store']);

Route::get('/product/{id}', [ProductController::class,'GetById']);
Route::delete('/product/{id}', [ProductController::class,'destroy']);
Route::POST('/product/{id}', [ProductController::class,'update']);
