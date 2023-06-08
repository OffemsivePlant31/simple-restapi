<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->get('/books', [BookController::class, 'index']);

Route::middleware('auth:sanctum')->get('/books/genres', [GenreController::class, 'index']);
