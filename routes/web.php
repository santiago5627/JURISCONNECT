<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\ExportController;
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
Route::get('/exportar-usuarios', [ExportController::class, 'exportUsers'])->name('exportar.usuarios');
Route::post('/upload-image', [ProfileController::class, 'upload'])->name('upload.image');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Exportaciones
    Route::get('/lawyers/export-pdf', [LawyerController::class, 'exportPDF'])
        ->name('lawyers.export.pdf');

    Route::get('/lawyers/export-excel', function () {
        return Excel::download(new LawyersExport, 'abogados.xlsx');
    })->name('lawyers.export.excel');

    // Abogados (CRUD)
    Route::resource('lawyers', LawyerController::class)->except(['edit', 'update', 'destroy']);

    // === DASHBOARDS ===

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/abogado', [AbogadoController::class, 'index'])->name('dashboard.abogado');
    Route::get('/dashboard/asistente', [AsistenteController::class, 'index'])->name('dashboard.asistente');


    // === PERFIL ===
    Route::get('/profile/avatar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/avatar', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::get('/perfil/foto', [ProfileController::class, 'editPhoto'])->name('profile.photo');
    Route::post('/perfil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::post('/upload-image', [ProfileController::class, 'uploadImage'])->name('upload-image');

    // === ABOGADOS ===

    Route::get('/lawyers/{lawyer}/edit', [LawyerController::class, 'edit'])->name('lawyers.edit');
    Route::put('/lawyers/{lawyer}', [LawyerController::class, 'update'])->name('lawyers.update');
    Route::delete('/lawyers/{lawyer}', [LawyerController::class, 'destroy'])->name('lawyers.destroy');
    Route::get('/lawyers/export-pdf', [LawyerController::class, 'exportPDF'])->name('lawyers.export.pdf');
    Route::get('/lawyers/export-excel', function () { return Excel::download(new LawyersExport, 'abogados.xlsx'); })->name('lawyers.export.excel');

    // === PROCESOS LEGALES ===
    Route::get('/mis-procesos', [LegalProcessController::class, 'index'])->name('mis.procesos');
    Route::get('/legal-processes/create', [LegalProcessController::class, 'create'])->name('legal_processes.create');
    Route::get('/procesos/create', [LegalProcessController::class, 'create'])->name('procesos.create');
    Route::post('/procesos', [LegalProcessController::class, 'store'])->name('procesos.store');
    Route::get('/procesos/{id}', [LegalProcessController::class, 'show']);

    // === CONCEPTOS JURÍDICOS === 
    Route::get('/abogado/mis-procesos', [AbogadoController::class, 'misProcesos'])->name('abogado.misConceptos');
    Route::get('/conceptos/create', [ConceptoController::class, 'create'])->name('conceptos.create');

    Route::post('/procesos/{proceso}/conceptos', [ConceptoController::class, 'store'])->name('conceptos.store');
    Route::get('/procesos/{id}/concepto', [AbogadoController::class, 'mostrarFormularioConcepto'])->name('abogado.crear-concepto');
    Route::post('/abogado/finalizar-proceso/{id}', [AbogadoController::class, 'finalizarProceso'])->name('abogado.finalizar-proceso');
    Route::get('/abogado/procesos', [AbogadoController::class, 'listarProcesos'])->name('abogado.listar-procesos');
    Route::post('/proceso/{id}/concepto', [AbogadoController::class, 'guardarConcepto'])->name('abogado.guardar-concepto');
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

    
// Ruta para subir la foto de perfil (POST)
Route::post('/user/profile-photo', [ProfileController::class, 'updateProfilePhoto'])
    ->middleware('auth')
    ->name('user.profile-photo');

// Si también quieres una ruta GET para mostrar la foto (opcional)
Route::get('/user/profile-photo-view', [ProfileController::class, 'showProfilePhoto'])
    ->middleware('auth')
    ->name('user.profile-photo.view');

    //Duplicados y existencia
Route::post('/lawyers/check-duplicates', [LawyerController::class, 'checkDuplicates']);
Route::post('/lawyers/check-field', [LawyerController::class, 'checkField']);

// Apunta a un método 'guardar' en un controlador llamado ImageController
Route::post('/guardar-imagen', [ImageController::class, 'guardar'])->name('imagenes.guardar');
Route::post('/user/profile-photo', [ProfileController::class, 'updatePhoto']) ->middleware('auth') ->name('profile.photo.update');// Protegida para que solo usuarios logueados puedan usarla

// Rutas de procesos legales
Route::resource('legal_processes', LegalProcessController::class);
Route::resource('conceptos', ConceptoController::class);
Route::get('/legal_processes/export/excel', [LegalProcessController::class, 'exportExcel'])
    ->name('legal_processes.export.excel');

Route::get('/legal_processes/export/pdf', [LegalProcessController::class, 'exportPdf'])
    ->name('legal_processes.export.pdf');


// Rutas de autenticación
require __DIR__ . '/auth.php';
