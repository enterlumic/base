<?php

namespace App\Console\Commands;
use App\Http\Controllers\ReportesController;

use Illuminate\Console\Command;
use App\Lib\LibCore;
use App\Http\Controllers\Ventas_servicios_264Controller;
use App\Http\Controllers\Contacto_cronController;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Throwable;
use App\Notifications\CorreoVentasServicios264 as ReporteVentasServicios264Email;

class ReporteVentasServicios264 extends Command{
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
    protected $signature = 'notificar:ReporteVentasServicios264';

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
        $request->merge(['vc_reporte' => 'ventas_servicios_264']);

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


        $flag_reporte = false;
        if (date('d') == 1) {
            $first_day = date('Y-m-d', mktime(0,0,0, date('m') - 1, 1, date('Y')));
            $current_day = date('Y-m-d', strtotime('-1 days'));
            $flag_reporte = true;
        }
        else {
            if (date('l') == "Saturday") {
                $first_day = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
                $current_day = date('Y-m-d');
                $flag_reporte = true;
            }
        }

        if ($flag_reporte) {
            $request->merge(['rango_fecha' => $first_day." to ".$current_day]);

            $exportarExcel= new Ventas_servicios_264Controller();

            $ruta_excel= $exportarExcel->get_ventas_servicios_264_by_excel($request);

            $ruta_excel= $this->path_reporte."public/".$ruta_excel;


            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = 'Reporte ventas (servicios) 264';
            $this->LibCore->setSkynet( $arr );

            try {
                $this->EnviarInfonotificar($ruta_excel);
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        }
        else {
            $this->info("Fecha incorrecta para envío de reporte, ".date('l')." ".date('d')."; ".date('d-m-Y H:i:s'));
        }
    }

    /**
     * Enviar información por correo.
     */
    protected function EnviarInfonotificar($ruta_excel){
        Notification::route('mail', $this->email)->notify(
            new ReporteVentasServicios264Email($ruta_excel)
        );
    }

}
