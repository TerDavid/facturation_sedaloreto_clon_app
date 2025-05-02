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
        Schema::create('manzana', function (Blueprint $table) {
            $table->id();

            // Nombre o código de la manzana (acepta texto y números)
            $table->string('manzana');

            // Relación foránea a la tabla sector
            $table->foreignId('id_sector')
                  ->constrained('sector')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manzana');
    }
};
