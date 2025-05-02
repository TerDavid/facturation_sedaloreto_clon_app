<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConsumosSinMedidorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consumos_sin_medidor', function (Blueprint $table) {
            $table->id();
            $table->enum('categoria', ['DOMESTICO','SOCIAL','COMERCIAL','INDUSTRIAL','ESTATAL'])
                  ->comment('Categoria tarifaria');
            $table->string('descripcion')
                  ->default('Con caja y sin medidor')
                  ->comment('Descripcion de la conexion sin medidor');
            $table->integer('asignado_m3')
                  ->comment('m3/mes estandar');
            $table->integer('asignado_m3_menos_5h')
                  ->nullable()
                  ->comment('DOMESTICO <5h/dia');
            $table->integer('asignado_m3_5h_o_mas')
                  ->nullable()
                  ->comment('DOMESTICO >=5h/dia');
            $table->timestamps();
        });

        // Poblar valores por defecto
        DB::table('consumos_sin_medidor')->insert([
            [
                'categoria'            => 'DOMESTICO',
                'asignado_m3'          => 20,
                'asignado_m3_menos_5h' => 12,
                'asignado_m3_5h_o_mas' => 20,
            ],
            [
                'categoria'            => 'SOCIAL',
                'asignado_m3'          => 20,
                'asignado_m3_menos_5h' => null,
                'asignado_m3_5h_o_mas' => null,
            ],
            [
                'categoria'            => 'COMERCIAL',
                'asignado_m3'          => 30,
                'asignado_m3_menos_5h' => null,
                'asignado_m3_5h_o_mas' => null,
            ],
            [
                'categoria'            => 'INDUSTRIAL',
                'asignado_m3'          => 50,
                'asignado_m3_menos_5h' => null,
                'asignado_m3_5h_o_mas' => null,
            ],
            [
                'categoria'            => 'ESTATAL',
                'asignado_m3'          => 45,
                'asignado_m3_menos_5h' => null,
                'asignado_m3_5h_o_mas' => null,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos_sin_medidor');
    }
}
