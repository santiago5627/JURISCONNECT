<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas resource para lawyers (incluye store, destroy, edit, update, etc.)
Route::resource('lawyers', LawyerController::class);

// Ruta personalizada para actualizar el avatar del usuario
Route::middleware('auth')->group(function() {
// Agregar esta línea en routes/web.php
Route::put('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});