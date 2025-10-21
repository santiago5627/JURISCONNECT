<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbogadoController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\LegalProcessController;
use App\Exports\LawyersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;


// Ruta por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
require __DIR__ . '/auth.php';

// Rutas públicas
Route::post('/validar-registro', [RegisteredUserController::class, 'validarRegistro'])->name('register.validate');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // === DASHBOARDS ===

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/abogado', [AbogadoController::class, 'index'])->name('dashboard.abogado');
    Route::get('/dashboard/asistente', [AsistenteController::class, 'index'])->name('dashboard.asistente');


    // === PERFIL ===
    Route::get('/perfil/foto', [ProfileController::class, 'editPhoto'])->name('profile.photo');
    Route::post('/perfil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    // === ABOGADOS ===
    // PRIMERO las rutas específicas (antes del resource)
    Route::get('/lawyers/export-pdf', [LawyerController::class, 'exportPDF'])->name('lawyers.export.pdf');
    Route::get('/lawyers/export-excel', function () { 
        return Excel::download(new LawyersExport, 'abogados.xlsx'); 
    })->name('lawyers.export.excel');
    Route::post('/lawyers/check-duplicates', [LawyerController::class, 'checkDuplicates']);
    Route::post('/lawyers/check-field', [LawyerController::class, 'checkField']);
    
    // DESPUÉS el resource (UNA SOLA VEZ)
    Route::resource('lawyers', LawyerController::class);

    // === PROCESOS LEGALES ===
    Route::get('/mis-procesos', [LegalProcessController::class, 'index'])->name('mis.procesos');
    Route::get('/legal-processes/create', [LegalProcessController::class, 'create'])->name('legal_processes.create');
    Route::get('/procesos/create', [LegalProcessController::class, 'create'])->name('procesos.create');
    Route::post('/procesos', [LegalProcessController::class, 'store'])->name('procesos.store');
    Route::get('/procesos/{id}', [LegalProcessController::class, 'show'])->name('procesos.show');
    Route::get('/procesos/{id}/edit', [LegalProcessController::class, 'edit'])->name('procesos.edit');
    Route::put('/procesos/{id}', [LegalProcessController::class, 'update'])->name('procesos.update');
    Route::delete('/procesos/{id}', [LegalProcessController::class, 'destroy'])->name('procesos.destroy');

    // === CONCEPTOS JURÍDICOS === 
    Route::get('/abogado/mis-procesos', [AbogadoController::class, 'misProcesos'])->name('abogado.misConceptos');
    Route::get('/conceptos/create', [ConceptoController::class, 'create'])->name('conceptos.create');
    Route::post('/procesos/{proceso}/conceptos', [ConceptoController::class, 'store'])->name('conceptos.store');
    Route::get('/procesos/{id}/concepto', [AbogadoController::class, 'mostrarFormularioConcepto'])->name('abogado.crear-concepto');
    Route::post('/abogado/finalizar-proceso/{id}', [AbogadoController::class, 'finalizarProceso'])->name('abogado.finalizar-proceso');
    Route::get('/abogado/procesos', [AbogadoController::class, 'listarProcesos'])->name('abogado.listar-procesos');
    Route::post('/abogado/proceso/{id}/concepto', [AbogadoController::class, 'guardarConcepto'])->name('abogado.guardar-concepto');
    Route::put('/procesos/{proceso}/conceptos/{concepto}', [AbogadoController::class, 'updateConcepto']) ->name('procesos.conceptos.update');
}); 

// === RESOURCES ===
Route::resource('lawyers', LawyerController::class)->middleware('auth')->except(['edit', 'update', 'destroy']);
Route::resource('procesos', LegalProcessController::class);
Route::resource('lawyers', LawyerController::class)->middleware('auth');



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


// Si también quieres una ruta GET para mostrar la foto (opcional)
Route::get('/user/profile-photo-view', [ProfileController::class, 'showProfilePhoto'])
    ->middleware('auth')
    ->name('user.profile-photo.view');

    //Duplicados y existencia
Route::post('/lawyers/check-duplicates', [LawyerController::class, 'checkDuplicates']);
Route::post('/lawyers/check-field', [LawyerController::class, 'checkField']);

// Rutas de procesos legales
Route::resource('legal_processes', LegalProcessController::class);
Route::resource('conceptos', ConceptoController::class);
Route::get('/legal_processes/export/excel', [LegalProcessController::class, 'exportExcel'])
    ->name('legal_processes.export.excel');

Route::get('/legal_processes/export/pdf', [LegalProcessController::class, 'exportPdf'])
    ->name('legal_processes.export.pdf');


// Rutas de autenticación
require __DIR__ . '/auth.php';
