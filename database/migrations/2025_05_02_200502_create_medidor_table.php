<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medidores', function (Blueprint $table) {
            $table->id();

            // Relación al cliente (ya con su ubicación y categoría)
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Datos del medidor
            $table->string('codigo')->unique();
            $table->date('fecha_instalacion')->nullable();
            $table->string('ubicacion_detallada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medidores');
    }
};
