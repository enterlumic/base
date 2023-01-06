<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Carrier_status;
use App\Lib\LibCore;

class Carrier_statusController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;

    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(){
        $this->LibCore = new LibCore();
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS carrier_status.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_carrier_status' , 'vc_info' => "index - carrier_status" ] );
        return view('carrier_status');
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_carrier_status_by_datatable(Request $request)
    {
        $fecha= isset($request->rango_fecha) && !empty($request->rango_fecha) 
        ? $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' ) 
        : ['dt_ini'=> date('Y-m-d', strtotime('-1 days')), 'dt_fin'=> date('Y-m-d', strtotime('-1 days')) ];

        $rango= isset($request->rango_fecha) && !empty($request->rango_fecha) ? 1 : 0;

        $this->LibCore->if_exists_sp('get_reporte_carrier_status', true);
        $sql  = "CALL get_reporte_carrier_status( '".$fecha['dt_ini']."' ,'".$fecha['dt_fin']."' , ".$rango." )";
        $data = DB::select($sql);

        foreach ($data as $key => $value) {
            $arr_data[]= array("Campana"=>$value->campana
                            , "Fecha"=>$value->fecha
                            , "Calls"=>$value->calls
                            , "Contactos %"=>$value->contactos
                            , "Logros"=>$value->logros
                            , "Logros E"=>$value->logros_e
                            , "% Efectividad"=>$value->efectividad
                            , "Tiempo de Conexion"=>$value->tiempo_conexion
                            , "SPH"=>$value->sph
                            , "Buzones"=>$value->buzonez
                            , "Promedio Buzones"=>$value->promedio_uzonez
            );
        }
        
        return  isset($arr_data) ? json_encode($arr_data) : '';
    }


    public function data_arr($key, $value)
    {
        return
        $data_insert=   [
                             'servidor'=> isset($value->servidor) ? $value->servidor: ''
                            ,'call_date'=> isset($value->call_date) ? $value->call_date: ''
                            ,'campana'=> isset($value->campana) ? $value->campana : ''
                            ,'dialstatus'=> isset($value->dialstatus) ? $value->dialstatus: ''
                            ,'calls'=> isset($value->op_time) ? $value->op_time : ''
                        ];
    }

    public function cronCarrierStatus(Request $request)
    {
        $fecha= $request->fecha;
        $sql= "EXEC get_report_carrier_status_sqlsrv @fecha_inicial='".$fecha."' , @fecha_final='".$fecha."'";
        $query= DB::connection('sqlsrv')->select($sql);

        if (isset($query) && is_array($query) && !empty($query)){
            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = "cronCarrierStatus";
            $this->LibCore->setSkynet( $arr );

            foreach ($query as $key => $value) {
                $data_insert[]= $this->data_arr($key, $value);
            }

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('carrier_status')->insert( $temp );
            }

        }else{
            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = "cronCarrierStatus";
            $arr['vc_query']  = $sql;
            $this->LibCore->setSkynet( $arr );
        }
      
    }
}

