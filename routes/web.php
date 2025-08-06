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
Route::delete('/lawyers/{lawyer}', [LawyerController::class, 'destroy'])->name('lawyers.destroy');
Route::get('/lawyers/{lawyer}/edit', [LawyerController::class, 'edit'])->name('lawyers.edit');
Route::put('/lawyers/{lawyer}', [LawyerController::class, 'update'])->name('lawyers.update');
Route::get('/exportar-usuarios', [ExportController::class, 'exportUsers'])->name('exportar.usuarios');

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function() {
Route::get('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
Route::put('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

Route::post('/validar-registro', [RegisteredUserController::class, 'validarRegistro'])->name('register.validate');



// Rutas para manejo de avatares (agregar después de las rutas existentes)
Route::middleware(['auth'])->group(function () {
    // Ruta para subir avatar
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    
    // Ruta para eliminar avatar
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});

// Si necesitas una ruta para servir las imágenes (opcional, solo si tienes problemas con storage:link)
Route::get('/avatars/{filename}', function ($filename) {
    $path = storage_path('app/public/avatars/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->where('filename', '.*')->name('avatar.serve');

//IMAGENES
Route::post('/upload-image', [App\Http\Controllers\ProfileController::class, 'uploadImage'])->name('upload-image');

