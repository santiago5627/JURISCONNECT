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
    Route::resource('lawyers', LawyerController::class);
    Route::get('/lawyers/export-pdf', [LawyerController::class, 'exportPDF'])->name('lawyers.export.pdf');
    Route::get('/lawyers/export-excel', function () { 
        return Excel::download(new LawyersExport, 'abogados.xlsx'); 
    })->name('lawyers.export.excel');
    Route::post('/lawyers/check-duplicates', [LawyerController::class, 'checkDuplicates']);
    Route::post('/lawyers/check-field', [LawyerController::class, 'checkField']);

    // === PROCESOS LEGALES ===
    Route::resource('legal_processes', LegalProcessController::class);
    Route::get('/mis-procesos', [LegalProcessController::class, 'index'])->name('mis.procesos');
    Route::get('/procesos/create', [LegalProcessController::class, 'create'])->name('procesos.create');
    Route::post('/procesos', [LegalProcessController::class, 'store'])->name('procesos.store');
    Route::get('/procesos/{id}', [LegalProcessController::class, 'show']);
    Route::get('/legal_processes/export/excel', [LegalProcessController::class, 'exportExcel'])->name('legal_processes.export.excel');
    Route::get('/legal_processes/export/pdf', [LegalProcessController::class, 'exportPdf'])->name('legal_processes.export.pdf');

    // === CONCEPTOS JURÍDICOS ===
    Route::resource('conceptos', ConceptoController::class);
    Route::get('/abogado/mis-procesos', [AbogadoController::class, 'misProcesos'])->name('abogado.misConceptos');
    Route::get('/conceptos/create', [ConceptoController::class, 'create'])->name('conceptos.create');
    Route::get('/procesos/{id}/concepto', [AbogadoController::class, 'mostrarFormularioConcepto'])->name('abogado.crear-concepto');
    Route::post('/procesos/{proceso}/concepto', [ConceptoController::class, 'store'])->name('procesos.conceptos.store');
    Route::post('/abogado/finalizar-proceso/{id}', [AbogadoController::class, 'finalizarProceso'])->name('abogado.finalizar-proceso');
    Route::get('/abogado/procesos', [AbogadoController::class, 'listarProcesos'])->name('abogado.listar-procesos');
    Route::post('/abogado/proceso/{id}/concepto', [AbogadoController::class, 'guardarConcepto'])->name('abogado.guardar-concepto');
    Route::put('/procesos/{proceso}/conceptos/{concepto}', [AbogadoController::class, 'updateConcepto'])->name('procesos.conceptos.update');
});