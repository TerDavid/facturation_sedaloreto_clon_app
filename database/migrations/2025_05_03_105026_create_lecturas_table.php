<?php

// database/migrations/2025_05_03_000000_create_lecturas_table.php

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
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();

            // Relación con técnico
            $table->foreignId('tecnico_id')
                  ->constrained('tecnicos')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relación con medidor
            $table->foreignId('medidor_id')
                  ->constrained('medidor')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Aquí relacionamos con el cliente a través de su código de suministro
            $table->string('codigo_suministro');
            $table->foreign('codigo_suministro')
                  ->references('codigo_suministro')
                  ->on('clientes')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Valor registrado
            $table->decimal('valor', 10, 2);

            // Fecha de lectura (por defecto ahora)
            $table->timestamp('fecha_lectura')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturas');
    }
};

