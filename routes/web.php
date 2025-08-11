<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Rutas resource para lawyers (incluye store, destroy, edit, update, etc.)
Route::resource('lawyers', LawyerController::class)->middleware('auth');

Route::get('/exportar-usuarios', [ExportController::class, 'exportUsers'])->name('exportar.usuarios');

Route::post('/validar-registro', [RegisteredUserController::class, 'validarRegistro'])->name('register.validate');



// GRUPO CONSOLIDADO: Rutas de perfil protegidas por autenticación
Route::middleware('auth')->group(function() {
    // Rutas básicas de perfil
    Route::get('/profile/avatar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/avatar', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de manejo de avatares/imágenes
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    
    // Ruta para subir imagen (la que estás usando actualmente)
    Route::post('/upload-image', [ProfileController::class, 'uploadImage'])->name('upload-image');
});

// Ruta para servir las imágenes si tienes problemas con storage:link
Route::post('/upload-image', [ProfileController::class, 'upload'])->name('upload.image');

