<?php

namespace App\Console\Commands;
use App\Http\Controllers\ReportesController;

use Illuminate\Console\Command;
use App\Lib\LibCore;
use App\Http\Controllers\Agentes_por_horaController;
use App\Http\Controllers\Contacto_cronController;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Throwable;
use App\Notifications\CorreoAgentesPorHora as ReporteAgentesPorHoraEmail;

class ReporteAgentesPorHora extends Command{
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
    protected $signature = 'notificar:ReporteAgentesPorHora';

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

        $contacto= new Contacto_cronController();
        $contacto= $contacto->get_contacto_cron_by_datatable($request);


        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $this->info("Iniciando proceso de envío de información " . date('d-m-Y H:i:s'));

        $request = new \Illuminate\Http\Request();
        $request->merge(['cron' => true]);
        $request->merge(['rango_fecha' => date('Y-m-d', strtotime('-1 days')) ]);

        $exportarExcel= new Agentes_por_horaController();
        $ruta_excel= $exportarExcel->get_agentes_por_hora_by_datatable($request);

        $ruta_excel= $this->path_reporte."/storage/app/public/".$ruta_excel;

        $arr['vc_evento']= 'init_cron';
        $arr['vc_info']  = 'Reporte agentes por hora';
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
            new ReporteAgentesPorHoraEmail($ruta_excel)
        );
    }

}
