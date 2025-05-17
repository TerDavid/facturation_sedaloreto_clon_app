<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTarifasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->enum('categoria', ['DOMESTICO','SOCIAL','COMERCIAL','INDUSTRIAL','ESTATAL'])
                  ->comment('Categoria tarifaria');
            $table->integer('rango_min')
                  ->comment('Consumo minimo inclusive en m3');
            $table->integer('rango_max')
                  ->nullable()
                  ->comment('Consumo maximo inclusive en m3; null = sin limite superior');
            $table->decimal('tarifa_agua', 8, 3)
                  ->comment('S/ por m3 de agua');
            $table->decimal('tarifa_alcantarillado', 8, 3)
                  ->comment('S/ por m3 de alcantarillado');
            $table->decimal('cargo_fijo', 6, 2)
                  ->comment('S/ cargo fijo mensual');
            $table->timestamps();
        });

        // Poblar valores por defecto
        DB::table('tarifas')->insert([
            // DOMESTICO
            [
                'categoria'             => 'DOMESTICO',
                'rango_min'             => 0,
                'rango_max'             => 8,
                'tarifa_agua'           => 1.820,
                'tarifa_alcantarillado' => 0.546,
                'cargo_fijo'            => 2.51,
            ],
            [
                'categoria'             => 'DOMESTICO',
                'rango_min'             => 8,
                'rango_max'             => 20,
                'tarifa_agua'           => 3.219,
                'tarifa_alcantarillado' => 0.966,
                'cargo_fijo'            => 2.39,
            ],
            [
                'categoria'             => 'DOMESTICO',
                'rango_min'             => 20,
                'rango_max'             => null,
                'tarifa_agua'           => 3.219,
                'tarifa_alcantarillado' => 0.966,
                'cargo_fijo'            => 2.39,
            ],
            // SOCIAL
            [
                'categoria'             => 'SOCIAL',
                'rango_min'             => 0,
                'rango_max'             => null,
                'tarifa_agua'           => 1.820,
                'tarifa_alcantarillado' => 0.546,
                'cargo_fijo'            => 2.39,
            ],
            // COMERCIAL
            [
                'categoria'             => 'COMERCIAL',
                'rango_min'             => 0,
                'rango_max'             => null,
                'tarifa_agua'           => 3.219,
                'tarifa_alcantarillado' => 0.966,
                'cargo_fijo'            => 2.39,
            ],
            // INDUSTRIAL
            [
                'categoria'             => 'INDUSTRIAL',
                'rango_min'             => 0,
                'rango_max'             => null,
                'tarifa_agua'           => 3.513,
                'tarifa_alcantarillado' => 1.054,
                'cargo_fijo'            => 2.39,
            ],
            // ESTATAL
            [
                'categoria'             => 'ESTATAL',
                'rango_min'             => 0,
                'rango_max'             => null,
                'tarifa_agua'           => 3.219,
                'tarifa_alcantarillado' => 0.966,
                'cargo_fijo'            => 2.39,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
}
