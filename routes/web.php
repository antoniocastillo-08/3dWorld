<?php

use App\Http\Controllers\ProfileController;
use App\Models\Printer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Model3dController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\DashboardController;

//Rutas para el modelo 3D
//|--------------------------------------------------------------------------
Route::get('/', [Model3dController::class, 'index'])->name('models3d.index');

Route::get('/model3d/{model}', [Model3dController::class, 'show'])->name('models3d.show');

Route::middleware(['auth'])->group(function () {
    // Crear y guardar modelos
    Route::get('/models3d/create', [Model3dController::class, 'create'])->name('models3d.create');
    Route::post('/models3d/store', [Model3dController::class, 'store'])->name('models3d.store');

    // Editar modelo
    Route::get('/models3d/{model}/edit', [Model3dController::class, 'edit'])->name('models3d.edit');
    Route::put('/models3d/{model}', [Model3dController::class, 'update'])->name('models3d.update');

    Route::post('/models3d/{id}/like', [Model3dController::class, 'like'])->name('models3d.like');
    Route::post('/models3d/{id}/unlike', [Model3dController::class, 'unlike'])->name('models3d.unlike');
    // Eliminar modelo
    Route::delete('/models3d/{model}', [Model3dController::class, 'destroy'])->name('models3d.destroy');
});

//Rutas para la gestión de Impresoras3d
//--------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/printers', [PrinterController::class, 'index'])->name('printers.index');
    Route::get('/printers/add', [PrinterController::class, 'add'])->name('printers.add');
    Route::get('/printers/customize/{printerId}', [PrinterController::class, 'customize'])->name('printers.customize');
    Route::post('/printers/attach', [PrinterController::class, 'attach'])->name('printers.attach');

    Route::get('/printers/{printerId}/edit', action: [PrinterController::class, 'edit'])->name('printers.edit');
    Route::put('/printers/{printerId}', [PrinterController::class, 'update'])->name('printers.update');
    
    Route::delete('/printers/{printerId}', [PrinterController::class, 'destroy'])->name('printers.destroy');
});




// Rutas para la autenticación
//|--------------------------------------------------------------------------
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/models3d/upload', function () {
    return view('models3d.upload');
});

require __DIR__ . '/auth.php';
