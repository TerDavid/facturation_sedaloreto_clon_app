<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Código de suministro único
            $table->string('code_suministro')
                  ->unique()
                  ->comment('Código único de suministro');

            // Datos básicos
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable()->unique();

            // Ubicación: ciudad → … → manzana
            $table->foreignId('id_manzana')
                  ->constrained('manzana')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Tipo de actividad / categoría para tarifas
            $table->enum('categoria', ['DOMESTICO','SOCIAL','COMERCIAL','INDUSTRIAL','ESTATAL'])
                  ->comment('Categoría tarifaria asignada al cliente');

            // Relación a la tarifa cuando el cliente tiene medidor
            $table->foreignId('tarifa_id')
                  ->constrained('tarifas')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete()
                  ->comment('Tarifa aplicable cuando hay medidor');

            // Si NO tiene medidor, vínculo con consumos_sin_medidor
            $table->foreignId('id_consumo_sin_medidor')
                  ->nullable()
                  ->constrained('consumos_sin_medidor')
                  ->cascadeOnUpdate()
                  ->nullOnDelete()
                  ->comment('Referencia a consumo estándar cuando NO hay medidor');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
