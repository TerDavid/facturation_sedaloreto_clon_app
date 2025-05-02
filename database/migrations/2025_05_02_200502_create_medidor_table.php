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
        Schema::create('medidor', function (Blueprint $table) {
            $table->id();

            // Código único alfanumérico del medidor
            $table->string('codigo_medidor')->unique();

            // Relación con sector
            $table->foreignId('id_sector')
                  ->constrained('sector')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relación con manzana
            $table->foreignId('id_manzana')
                  ->constrained('manzana')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relación con ciudad
            $table->foreignId('ciudad_id')
                  ->constrained('ciudades')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Estado del medidor: 0, 1 o 2 (por defecto 1)
            $table->tinyInteger('estado_medidor')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medidor');
    }
};
