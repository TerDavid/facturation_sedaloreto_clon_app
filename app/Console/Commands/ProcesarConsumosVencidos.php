<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consumo;
use App\Http\Controllers\ConsumoController;

class ProcesarConsumosVencidos extends Command
{
    protected $signature   = 'consumos:calcular-valores';
    protected $description = 'Calcula valor y conceptos para consumos vencidos, reintentando hasta completarlos';

    public function handle()
    {
        // 1) Fecha límite: hoy (se calculan los vencidos antes de hoy)
        $hoy = now()->toDateString();

        // 2) Trae todos los consumos con m3_consumidos, sin valor y con vencimiento < hoy
        $pendientes = Consumo::whereNotNull('m3_consumidos')
            ->whereNull('valor')
            ->whereDate('fecha_vencimiento', '<', $hoy)
            ->get();

        if ($pendientes->isEmpty()) {
            $this->info('No hay consumos vencidos pendientes.');
            return;
        }

        // 3) Invoca tu lógica de cálculo desde el controlador
        $ctrl = app(ConsumoController::class);

        foreach ($pendientes as $consumo) {
            [$total, $conceptos] = $ctrl->calcularValorYConceptos($consumo);
            $consumo->update([
                'valor'     => $total,
                'conceptos' => json_encode($conceptos),
            ]);
        }

        $this->info("Se procesaron {$pendientes->count()} consumos vencidos.");
    }
}
