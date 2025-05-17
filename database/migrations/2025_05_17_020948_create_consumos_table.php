<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();

            // Relación al cliente
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Consumo en m³: inicialmente vacío, se llenará desde la vista
            $table->integer('m3_consumidos')
                  ->nullable();

            // Fecha y hora del registro de consumo
            $table->timestamp('hora_registro_consumo')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
