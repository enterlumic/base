<?php

namespace App\Console\Commands;
use App\Http\Controllers\ReportesController;

use Illuminate\Console\Command;
use App\Lib\LibCore;
use App\Http\Controllers\CronController;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Throwable;
use App\Notifications\CorreoCloserLog as ReporteCloserLogEmail;

class ReporteCloserLog extends Command{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;
    public $path_reporte;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificar:ReporteCloserLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía por correo los tipos de servicio activos para notificar';

    /**
     * correo destino.
     *
     * @var string
     */
    public $email;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        $request = new \Illuminate\Http\Request();
        $request->merge(['cron' => true]);
        $request->merge(['vc_reporte' => 'agentes_por_hora']);

        $this->email = (['cmurillo@teiker.mx', 'ralvarez@teiker.mx', 'system@tecsa.pp', 'marmendariz@teiker.mx', 'hquintanilla@teiker.mx']);

        $this->LibCore = new LibCore();
        $this->path_reporte = isset($_SERVER['PWD']) ? $_SERVER['PWD'] : '';

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $this->info("Iniciando proceso de envío de información " . date('d-m-Y H:i:s'));

        $exportarExcel= new CronController();
        $ruta_excel= $exportarExcel->closeLog();

        $ruta_excel= $this->path_reporte."/storage/app/public/".$ruta_excel;

        $arr['vc_evento']= 'init_cron';
        $arr['vc_info']  = 'Reporte Vicidial Log';
        $this->LibCore->setSkynet( $arr );

        try {
            $this->EnviarInfonotificar($ruta_excel);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

    }

    /**
     * Enviar información por correo.
     */
    protected function EnviarInfonotificar($ruta_excel){
        Notification::route('mail', $this->email)->notify(
            new ReporteCloserLogEmail($ruta_excel)
        );
    }

}
