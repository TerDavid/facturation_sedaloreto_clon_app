<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Inserción de las 3 ciudades por defecto
        DB::table('ciudades')->insert([
            ['nombre' => 'Iquitos'],
            ['nombre' => 'Yurimaguas'],
            ['nombre' => 'Requena'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ciudades');
    }
};
