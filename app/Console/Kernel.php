<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ProcesarConsumosVencidos::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Ejecuta consumos:calcular-valores cada minuto, sin condiciones
        $schedule
            ->command('consumos:calcular-valores')
            ->everyMinute()
            ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
