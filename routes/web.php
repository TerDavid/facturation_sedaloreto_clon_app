<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantaTratamientoController;
use App\Http\Controllers\BombaAguaController;
use App\Http\Controllers\ReservorioController;
use App\Http\Controllers\SectorController;


use App\Http\Controllers\RelationController;
use App\Http\Controllers\SectorRelationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Rutas para Planta de Tratamiento
Route::get('planta-tratamiento', [PlantaTratamientoController::class, 'index'])
    ->name('planta-tratamiento.index');

Route::get('planta-tratamiento/create', [PlantaTratamientoController::class, 'create'])
    ->name('planta-tratamiento.create');

Route::post('planta-tratamiento', [PlantaTratamientoController::class, 'store'])
    ->name('planta-tratamiento.store');

Route::resource('bomba-agua', BombaAguaController::class);
Route::resource('reservorio', ReservorioController::class);
Route::resource('sector', SectorController::class);

Route::get('sede', [SectorRelationController::class, 'index'])
     ->name('sede.index');

});



require __DIR__.'/auth.php';
