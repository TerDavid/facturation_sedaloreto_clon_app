<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bomba_agua', function (Blueprint $table) {
            $table->id();

            // Aquí guardaremos el nombre o código de la bomba
            $table->string('bomba');

            // Relación foránea a la tabla ciudades
            $table->foreignId('id_ciudades')
                  ->constrained('ciudades')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bomba_agua');
    }
};
