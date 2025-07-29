<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Exports\LawyersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Lawyer;

Route::get('/lawyers/export-pdf', function () {
    $lawyers = Lawyer::all();
    $pdf = Pdf::loadView('exports.lawyers-pdf', compact('lawyers'));
    return $pdf->download('abogados.pdf');
})->name('lawyers.export.pdf');


Route::get('/lawyers/export-excel', function () {
    return Excel::download(new LawyersExport, 'abogados.xlsx');
})->name('lawyers.export.excel');


Route::get('/perfil/foto', [ProfileController::class, 'editPhoto'])->name('profile.photo');
Route::post('/perfil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/lawyers', [LawyerController::class, 'store'])->name('lawyers.store');
require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::post('/lawyers', [App\Http\Controllers\LawyerController::class, 'store'])->name('lawyers.store');

Route::delete('/lawyers/{lawyer}', [LawyerController::class, 'destroy'])->name('lawyers.destroy');
Route::get('/lawyers/{lawyer}/edit', [LawyerController::class, 'edit'])->name('lawyers.edit');
Route::put('/lawyers/{lawyer}', [LawyerController::class, 'update'])->name('lawyers.update');

Route::get('/dashboard/abogado', function () {
    return view('dashboard-abogado'); // Crea esa vista
})->middleware(['auth'])->name('dashboard.abogado');
