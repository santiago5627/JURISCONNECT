<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;

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
