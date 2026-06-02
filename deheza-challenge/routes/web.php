<?php

use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('solicitudes.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('solicitudes', SolicitudController::class);
    Route::get('/reporte/resumen', [ReporteController::class, 'resumen'])->name('reporte.resumen');
});

require __DIR__.'/auth.php';
