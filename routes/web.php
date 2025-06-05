<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckCompany;
use App\Models\Printer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Model3dController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilamentController;
use App\Http\Controllers\CompanyController;

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
Route::middleware(['auth', CheckCompany::class])->group(function () {
    Route::get('/printers', [PrinterController::class, 'index'])->name('printers.index');
    Route::get('/printers/add', [PrinterController::class, 'add'])->name('printers.add');
    Route::get('/printers/customize/{printerId}', [PrinterController::class, 'customize'])->name('printers.customize');
    Route::post('/printers/attach', [PrinterController::class, 'attach'])->name('printers.attach');

    Route::get('/printers/{printerId}/edit', action: [PrinterController::class, 'edit'])->name('printers.edit');
    Route::put('/printers/{printer}/notes', [PrinterController::class, 'updateNotes'])->name('printers.updateNotes');

    Route::put('/printers/{printerId}', [PrinterController::class, 'update'])->name('printers.update');


    Route::post('/printers/{printer}/filaments/{filament}/add', [PrinterController::class, 'addFilament'])->name('printers.addFilament');
    Route::delete('/printers/{printer}/filaments/{filament}/remove', [PrinterController::class, 'removeFilament'])->name('printers.removeFilament');

    Route::delete('/printers/{printerId}', [PrinterController::class, 'destroy'])->name('printers.destroy');
});

//Rutas para la gestión de Filamentos
//--------------------------------------------------------------------------
Route::middleware(['auth', CheckCompany::class])->group(function () {
    Route::get('/filaments', [FilamentController::class, 'create'])->name('filaments.create');
    Route::post('/filaments/store', [FilamentController::class, 'store'])->name('filaments.store');

    Route::get('/filaments/edit', [FilamentController::class, 'edit'])->name('filaments.edit');
    Route::put('/filaments/update', [FilamentController::class, 'update'])->name('filaments.update');

    Route::delete('/filaments/{filament}', [FilamentController::class, 'destroy'])->name('filaments.destroy');
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

Route::middleware(['auth'])->group(function () {
    Route::get('/company/options', [CompanyController::class, 'showOptions'])->name('company.options');
    Route::post('/company/join', [CompanyController::class, 'joinCompany'])->name('company.join');
    Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/company/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::patch('/employees/{user}/fire', [CompanyController::class, 'fire'])->name('company.fire');
    Route::post('/join-request', [CompanyController::class, 'requestJoinCompany'])->name('join.request');
    Route::patch('/join-request/{joinRequest}/respond', [CompanyController::class, 'respondToJoinRequest'])->name('join.respond');
    Route::delete('/company/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');

});


Route::get('/models3d/upload', function () {
    return view('models3d.upload');
});

require __DIR__ . '/auth.php';
