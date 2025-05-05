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
use App\Http\Controllers\GestionClienteController;
use App\Http\Controllers\GestionFacturacionController;
use App\Http\Controllers\ConsultaFacturaController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\SectorRelationController;
use App\Http\Controllers\TecnicoController;

// ← Eliminada la ruta de closure que devolvía view('welcome')

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// GET "/" → muestra el formulario con la lista de ciudades
Route::get('/', [ConsultaFacturaController::class, 'index'])
     ->name('home');

// POST "/" → procesa el formulario y vuelve a welcome.blade.php
Route::post('/', [ConsultaFacturaController::class, 'consultar'])
     ->name('consulta-factura.consultar');

/*
|--------------------------------------------------------------------------
| Dashboard y perfil
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Rutas de Planta de Tratamiento, Bomba, Reservorio, Sector, Manzana
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Relaciones de Sedes y Sectores
    |--------------------------------------------------------------------------
    */
    Route::get('sede', [SectorRelationController::class, 'index'])
         ->name('sede.index');
    Route::get('sede/sectores', [SectorRelationController::class, 'sectores'])
         ->name('sede.sectores');

    /*
    |--------------------------------------------------------------------------
    | Clientes y Medidores
    |--------------------------------------------------------------------------
    */
    Route::get('clientes', [ClienteController::class,'index'])
         ->name('clientes.index');
    Route::get('clientes/{ciudad}', [ClienteController::class,'show'])
         ->name('clientes.show');

    // 1️⃣ Sectores de la ciudad
    Route::get('clientes/{ciudad}/sectores', [MedidorController::class,'sectores'])
         ->name('medidores.sectores');

    // 2️⃣ Medidores de un sector
    Route::get('clientes/{ciudad}/sectores/{sector}/medidores', [MedidorController::class,'index'])
         ->name('medidores.index');

    // CRUD de medidores
    Route::prefix('clientes/{ciudad}/sectores/{sector}/medidores')
         ->name('medidores.')
         ->group(function(){
             Route::get('create',  [MedidorController::class,'create'])->name('create');
             Route::post('/',      [MedidorController::class,'store'])->name('store');
             Route::get('{medidor}/edit', [MedidorController::class,'edit'])->name('edit');
             Route::put('{medidor}',      [MedidorController::class,'update'])->name('update');
             Route::delete('{medidor}',   [MedidorController::class,'destroy'])->name('destroy');
         });

    /*
    |--------------------------------------------------------------------------
    | Gestión de Clientes
    |--------------------------------------------------------------------------
    */
    Route::prefix('clientes/{ciudad}/gestion')
        ->name('gestion_clientes.')
        ->controller(GestionClienteController::class)
        ->group(function(){
            Route::get('/',              'index')->name('index');
            Route::get('create',         'create')->name('create');
            Route::post('/',             'store')->name('store');
            Route::get('{cliente}/edit', 'edit')->name('edit');
            Route::put('{cliente}',      'update')->name('update');
            Route::delete('{cliente}',   'destroy')->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Gestión de Facturación (sectores y facturas)
    |--------------------------------------------------------------------------
    */
    Route::prefix('clientes/{ciudad}/facturacion')
         ->name('facturacion.')
         ->controller(GestionFacturacionController::class)
         ->group(function(){
             Route::get('sectores',                         'sectores')->name('sectores');
             Route::get('sectores/{sector}/clientes',       'clientes')->name('clientes');
             Route::get('sectores/{sector}/create',         'create')->name('create');
             Route::post('sectores/{sector}',               'store')->name('store');
             Route::get('sectores/{sector}/{factura}/edit', 'edit')->name('edit');
             Route::put('sectores/{sector}/{factura}',      'update')->name('update');
             Route::delete('sectores/{sector}/{factura}',   'destroy')->name('destroy');
         });


         Route::view('tecnico', 'tecnico.index')->name('tecnico.index');
        Route::view('tecnico/create', 'tecnico.create')->name('tecnico.create');
        Route::view('tecnico/assign', 'tecnico.assign')->name('tecnico.assign');
        Route::post('tecnico', [TecnicoController::class, 'store'])->name('tecnico.store');

        Route::resource('tecnico', TecnicoController::class);


});

require __DIR__.'/auth.php';
