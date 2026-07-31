<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- ROUTES PUBLIQUES (Tout le monde peut voir) ---
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/photos', [PhotoController::class, 'index']); // Filtre par ?category_id=X possible
Route::get('/photos/{photo}', [PhotoController::class, 'show']);

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- ROUTES PROTÉGÉES (Utilisateurs connectés - Bearer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/categories', [CategoryController::class, 'store']);

    // Actions sur les photos
    Route::post('/photos', [PhotoController::class, 'store']); // Upload (multipart/form-data)
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy']); // Supprimer sa photo

    // Likes
    Route::post('/photos/{photo}/like', [PhotoController::class, 'toggleLike']);
});
