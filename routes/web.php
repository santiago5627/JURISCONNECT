<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbogadoController;
use App\Http\Controllers\AsistenteController;
use App\Models\Lawyer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LawyersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\LegalProcessController;
// rutas/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/mis-procesos', [App\Http\Controllers\AbogadoController::class, 'misProcesos'])->name('mis.procesos');
    Route::get('/conceptos/create', [App\Http\Controllers\AbogadoController::class, 'crearConcepto'])->name('conceptos.create');
    Route::get('/legal-processes/create', [App\Http\Controllers\LegalProcessController::class, 'create'])->name('legal_processes.create');
});

// Ruta por defecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboards según rol
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard'); // Administrador
    Route::get('/dashboard/abogado', [AbogadoController::class, 'index'])->name('dashboard.abogado'); // Abogado
    Route::get('/dashboard/asistente', [AsistenteController::class, 'index'])->name('dashboard.asistente'); // Asistente Jurídico

    // Perfil (foto)
    Route::get('/perfil/foto', [ProfileController::class, 'editPhoto'])->name('profile.photo');
    Route::post('/perfil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    // Abogados (CRUD)
    Route::resource('lawyers', LawyerController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/lawyers/{lawyer}/edit', [LawyerController::class, 'edit'])->name('lawyers.edit');
    Route::put('/lawyers/{lawyer}', [LawyerController::class, 'update'])->name('lawyers.update');
    Route::delete('/lawyers/{lawyer}', [LawyerController::class, 'destroy'])->name('lawyers.destroy');

    // Exportaciones
    Route::get('/lawyers/export-pdf', function () {
        $lawyers = Lawyer::all();
        $pdf = Pdf::loadView('exports.lawyers-pdf', compact('lawyers'));
        return $pdf->download('abogados.pdf');
    })->name('lawyers.export.pdf');

    Route::get('/lawyers/export-excel', function () {
        return Excel::download(new LawyersExport, 'abogados.xlsx');
    })->name('lawyers.export.excel');
});

// Rutas de autenticación
require __DIR__ . '/auth.php';
