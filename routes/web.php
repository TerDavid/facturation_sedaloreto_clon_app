<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantaTratamientoController;
use App\Http\Controllers\BombaAguaController;
use App\Http\Controllers\ReservorioController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ManzanaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MedidorController;


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
Route::resource('manzana', ManzanaController::class);

Route::get('sede', [SectorRelationController::class, 'index'])
     ->name('sede.index');

Route::get('sede/sectores', [SectorRelationController::class, 'sectores'])
->name('sede.sectores');


Route::get('clientes', [ClienteController::class,'index'])
     ->name('clientes.index');

Route::get('clientes/{ciudad}', [ClienteController::class,'show'])
     ->name('clientes.show');



// 1️⃣ Listar sectores de la ciudad
Route::get('clientes/{ciudad}/sectores',
    [MedidorController::class,'sectores'])
    ->name('medidores.sectores');

// 2️⃣ Listar medidores de un sector en esa ciudad
Route::get('clientes/{ciudad}/sectores/{sector}/medidores',
    [MedidorController::class,'index'])
    ->name('medidores.index');

// Crear, editar, eliminar medidores, pasando ciudad y sector
Route::prefix('clientes/{ciudad}/sectores/{sector}/medidores')
     ->name('medidores.')
     ->group(function(){
         Route::get('create',  [MedidorController::class,'create'])->name('create');
         Route::post('/',      [MedidorController::class,'store'])->name('store');
         Route::get('{medidor}/edit', [MedidorController::class,'edit'])->name('edit');
         Route::put('{medidor}',      [MedidorController::class,'update'])->name('update');
         Route::delete('{medidor}',   [MedidorController::class,'destroy'])->name('destroy');
     });





});



require __DIR__.'/auth.php';
