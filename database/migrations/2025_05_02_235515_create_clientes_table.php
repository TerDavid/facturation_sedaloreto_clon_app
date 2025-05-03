<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni')->unique();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion')->nullable();

            // Código de suministro (puede quedar nulo y debe ser único si existe)
            $table->string('codigo_suministro')->nullable()->unique();

            // Estado del cliente (0=inactivo,1=activo,2=otro)
            $table->tinyInteger('estado')->default(1);

            // Relaciones
            // Ciudad
            $table->foreignId('ciudad_id')
                  ->nullable()
                  ->constrained('ciudades')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Sector
            $table->foreignId('sector_id')
                  ->nullable()
                  ->constrained('sector')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Manzana
            $table->foreignId('manzana_id')
                  ->nullable()
                  ->constrained('manzana')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Medidor (para enlazar al estado_medidor en la tabla medidor)
            $table->foreignId('medidor_id')
                  ->nullable()
                  ->constrained('medidor')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Tarifa aplicable
            $table->foreignId('tarifa_id')
                  ->nullable()
                  ->constrained('tarifas')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Consumo sin medidor (subsidios, casos especiales, etc.)
            $table->foreignId('consumo_sin_medidor_id')
                  ->nullable()
                  ->constrained('consumos_sin_medidor')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
