<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Lib\LibCore;

class Kernel extends ConsoleKernel
{

    public $LibCore;
    protected $commands = [
        // Commands\ReporteAgentesPorHora::class,
        // Commands\ReporteCloserLog::class,
        // Commands\Cron::class,
        // Commands\ReporteVentasServicios264::class
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $request = new \Illuminate\Http\Request();
        $request->merge(['vc_reporte' => 'agentes_por_hora']);


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
