<?php
namespace App\Console\Commands;
use App\Http\Controllers\ReportesController;
use Illuminate\Console\Command;
use App\Lib\LibCore;

use App\Http\Controllers\Agentes_por_horaController;
use App\Http\Controllers\Contacto_cronController;
use App\Http\Controllers\Carrier_statusController;
use App\Http\Controllers\Metricas_conexionesController;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Throwable;

class Cron extends Command{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificar:Cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $request = new \Illuminate\Http\Request();
        $request->merge(['fecha' => date('Y-m-d', strtotime('-1 days')) ]);

        $class= new Agentes_por_horaController();
        $class->cronAgentesPorHora($request);

        $class= new Carrier_statusController();
        $class->cronCarrierStatus($request);

        $class= new Metricas_conexionesController();
        $class->cronMetricasConexiones($request);
    }
}
