<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Model3dController;

Route::get('/', [Model3dController::class, 'index'])->name('models3d.index');

Route::get('/model3d/{model}', [Model3dController::class, 'show'])->name('models3d.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/models3d/create', [Model3dController::class, 'create'])->name('models3d.create');
    Route::post('/models3d/store', [Model3dController::class, 'store'])->name('models3d.store');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/models3d/upload', function () {
    return view('models3d.upload');
});

require __DIR__.'/auth.php';
