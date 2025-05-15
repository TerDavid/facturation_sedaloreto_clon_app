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
use App\Http\Controllers\SectorRelationController;
use App\Http\Controllers\TecnicoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Formulario de consulta
Route::get('/', [ConsultaFacturaController::class, 'index'])
     ->name('home');
Route::post('/', [ConsultaFacturaController::class, 'consultar'])
     ->name('consulta-factura.consultar');

/*
|--------------------------------------------------------------------------
| Dashboard y perfil
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => view('dashboard'))
     ->middleware(['auth','verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Planta, Bomba, Reservorio, Sector, Manzana
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
    Route::resource('sector',     SectorController::class);
    Route::resource('manzana',    ManzanaController::class);

    /*
    |--------------------------------------------------------------------------
    | Relaciones de Sedes y Sectores
    |--------------------------------------------------------------------------
    */
    Route::get('sede',          [SectorRelationController::class,'index'])
         ->name('sede.index');
    Route::get('sede/sectores', [SectorRelationController::class,'sectores'])
         ->name('sede.sectores');

    /*
    |--------------------------------------------------------------------------
    | Clientes y Medidores
    |--------------------------------------------------------------------------
    */
    // Route::get('clientes', [ClienteController::class,'index'])
    //      ->name('clientes.index');

    // — Gestión de Clientes SIN {ciudad} en la URI
    Route::prefix('clientes/gestion')
    ->name('gestion_clientes.')
    ->controller(GestionClienteController::class)
    ->group(function(){
        Route::get('/',          'index')->name('index');
        Route::post('/',         'store')->name('store');
        Route::put('{cliente}',  'update')->name('update');
        Route::delete('{cliente}','destroy')->name('destroy');
    });


    // — Rutas que sí usan {ciudad}
    Route::prefix('clientes/{ciudad}')
         ->whereNumber('ciudad')
         ->group(function(){
             // Mostrar un cliente por ciudad
             Route::get('/', [ClienteController::class,'show'])
                  ->name('clientes.show');

             // Sectores + Medidores
             Route::get('sectores', [MedidorController::class,'sectores'])
                  ->name('medidores.sectores');

             Route::prefix('sectores/{sector}/medidores')
                  ->whereNumber('sector')
                  ->group(function(){
                      Route::get('/',       [MedidorController::class,'index'])
                           ->name('medidores.index');
                      Route::get('create',  [MedidorController::class,'create'])
                           ->name('medidores.create');
                      Route::post('/',      [MedidorController::class,'store'])
                           ->name('medidores.store');
                      Route::get('{medidor}/edit',   [MedidorController::class,'edit'])
                           ->name('medidores.edit');
                      Route::put('{medidor}',        [MedidorController::class,'update'])
                           ->name('medidores.update');
                      Route::delete('{medidor}',     [MedidorController::class,'destroy'])
                           ->name('medidores.destroy');
                  });

             // Facturación
             Route::prefix('facturacion')
                  ->name('facturacion.')
                  ->controller(GestionFacturacionController::class)
                  ->group(function(){
                      Route::get('sectores',                   'sectores')->name('sectores');
                      Route::get('sectores/{sector}/clientes', 'clientes')->name('clientes');
                      Route::get('sectores/{sector}/create',   'create')->name('create');
                      Route::post('sectores/{sector}',         'store')->name('store');
                      Route::get('sectores/{sector}/{factura}/edit', 'edit')->name('edit');
                      Route::put('sectores/{sector}/{factura}',      'update')->name('update');
                      Route::delete('sectores/{sector}/{factura}',   'destroy')->name('destroy');
                  });
         });

    /*
    |--------------------------------------------------------------------------
    | Técnicos
    |--------------------------------------------------------------------------
    */
    Route::view('tecnico',        'tecnico.index')->name('tecnico.index');
    Route::view('tecnico/create', 'tecnico.create')->name('tecnico.create');
    Route::view('tecnico/assign', 'tecnico.assign')->name('tecnico.assign');
    Route::post('tecnico', [TecnicoController::class,'store'])->name('tecnico.store');
    Route::resource('tecnico', TecnicoController::class);
});

require __DIR__.'/auth.php';
