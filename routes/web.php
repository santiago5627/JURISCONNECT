<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController; // Asegúrate de que esta línea esté presente
use App\Http\Controllers\ProfileController; // Asegúrate de que esta línea esté presente si usas ProfileController

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas resource para lawyers (incluye store, destroy, edit, update, etc.)
Route::resource('lawyers', LawyerController::class)->middleware('auth'); // Añade middleware 'auth' si todas las rutas de lawyers lo requieren

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function() {
    // Rutas de perfil (si las usas)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Ruta de perfil estándar
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Ruta de perfil estándar
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Ruta de perfil estándar
    Route::patch('/upload-image', [ImageController::class, 'subirimage'])->name('image'); //Ruta de subir imagen
    

});