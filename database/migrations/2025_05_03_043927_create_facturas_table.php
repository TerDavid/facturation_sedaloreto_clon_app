<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            // REFERENCIAS DESDE CLIENTES
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relaciones “opcionales” (pueden ser null)
            $table->foreignId('ciudad_id')
                  ->nullable()
                  ->constrained('ciudades')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('sector_id')
                  ->nullable()
                  ->constrained('sector')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('manzana_id')
                  ->nullable()
                  ->constrained('manzana')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('medidor_id')
                  ->nullable()
                  ->constrained('medidor')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('tarifa_id')
                  ->nullable()
                  ->constrained('tarifas')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->foreignId('consumo_sin_medidor_id')
                  ->nullable()
                  ->constrained('consumos_sin_medidor')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // CAMPOS PROPIOS DE FACTURA
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->decimal('valor_pago', 10, 2)->nullable();
            $table->string('numero_recibo')->unique();
            $table->string('mes_factura');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};

