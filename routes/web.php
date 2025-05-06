<?php

use App\Http\Controllers\PrinterController;
use App\Http\Controllers\Model3dController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Printer;
use App\Models\Model3d;

Route::get('/', [Model3dController::class, 'index'])->name('models3d.index');

Route::get('models3d/{model3d}', [Model3dController::class, 'show'])->name('models.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    // Ruta para listar impresoras (accesible para todos los usuarios autenticados)
    Route::get('/printers', [PrinterController::class, 'index'])->name('printers.index');

    // Rutas para editar y eliminar impresoras (solo para administradores)
    Route::middleware('role:admin')->group(function () {
        Route::get('/printers/{printer}/edit', [PrinterController::class, 'edit'])->name('printers.edit');
        Route::delete('/printers/{printer}', [PrinterController::class, 'destroy'])->name('printers.destroy');
    });
});

require __DIR__.'/auth.php';
