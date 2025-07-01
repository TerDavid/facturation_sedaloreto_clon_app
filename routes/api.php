<?php

use App\Http\Controllers\Api\CiudadesController;
use App\Http\Controllers\Api\ClientesController;
use App\Http\Controllers\Api\SectorController;
use App\Http\Controllers\Api\FacturacionEmitirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('api')
    ->name('api.')
    // ->middleware(['auth'])
    ->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::prefix('ciudades')
            ->group(function () {
                Route::get('/{ciudad}/sectores', [CiudadesController::class, 'sectores'])
                    ->name('ciudades.sectores');
            });

        Route::prefix('sector')
            ->group(function (): void {
                Route::get('/{sector}/manzanas', [SectorController::class, 'manzanas'])
                    ->name('sector.manzanas');
            });
        Route::prefix('facturacion')
            ->group(function (): void {
                Route::resource('emitir', FacturacionEmitirController::class);
                Route::get('/get-informacion-consumo-cliente', [FacturacionEmitirController::class, 'getInformacionConsumoCliente'])
                    ->name('emitir.get-informacion-consumo-cliente');
            });
        Route::prefix('clientes')
            ->group(function (): void {
                Route::get('/search', [ClientesController::class, 'searchCliente'])
                    ->name('clientes.search');
            });
    });
