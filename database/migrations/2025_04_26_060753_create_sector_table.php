<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sector', function (Blueprint $table) {
            $table->id();

            // Nombre o código del sector (acepta texto y números)
            $table->string('sector');

            // Relación foránea a la tabla reservorio
            $table->foreignId('id_reservorio')
                  ->constrained('reservorio')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relación foránea a la tabla bomba_agua
            $table->foreignId('id_bomba_agua')
                  ->constrained('bomba_agua')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relación foránea a la tabla ciudades
            $table->foreignId('id_ciudad')
                  ->constrained('ciudades')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sector');
    }
};
