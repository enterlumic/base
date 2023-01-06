<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Agentes_por_hora;
use App\Models\Reporte_agentes_por_hora;
use App\Lib\LibCore;

class Agentes_por_horaController extends Controller
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
    | Todo es controlado por JS agentes_por_hora.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('agentes_por_hora')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla agentes_por_hora"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_agentes_por_hora' , 'vc_info' => "index - agentes_por_hora" ] );
        return view('agentes_por_hora');
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_agentes_por_hora_by_datatable(Request $request)
    {
        $fecha= isset($request->rango_fecha) && !empty($request->rango_fecha)
        ? $request->rango_fecha 
        : date('Y-m-d', strtotime('-1 days'));

        if ( !isset($request->cron) ){

            $total= Agentes_por_hora::where('dt_fecha', $fecha)->count();

            if ($total == 0){
                $consultal_srv= $this->consultal_srv($fecha);

                if (is_array($consultal_srv) && !empty($consultal_srv)){
                    foreach ($consultal_srv as $key => $value) {
                        $data_insert[]= $this->data_arr($value);
                        unset($data_arr);
                    }

                    foreach (array_chunk($data_insert,1000) as $temp)  
                    {
                        DB::table('agentes_por_hora')->insert( $temp );
                    }

                    $sql= "CALL get_agentes_por_hora( '".$fecha."' )";
                    $data = DB::select($sql);
                }
            }

            $data= Reporte_agentes_por_hora::select("id", "total", "hora_8", "hora_9", "hora_10"
                , "hora_11", "hora_12", "hora_13", "hora_14", "hora_15", "hora_16"
                , "hora_17", "hora_18", "hora_19", "hora_20", "hora_21")->where("fecha", $fecha);
            $total  = $data->count();

            foreach ($data->get() as $key => $value) {
                $arr_data[]= array(   $value->total
                                    , $value->hora_8
                                    , $value->hora_9
                                    , $value->hora_10
                                    , $value->hora_11
                                    , $value->hora_12 
                                    , $value->hora_13
                                    , $value->hora_14
                                    , $value->hora_15
                                    , $value->hora_16
                                    , $value->hora_17
                                    , $value->hora_18
                                    , $value->hora_19
                                    , $value->hora_20
                                    , $value->hora_21
                );
            }

            $json_data = array(
                "draw"            => intval( 10 ),   
                "recordsTotal"    => intval( $total ),  
                "recordsFiltered" => intval( $total ),
                "data"            => isset($arr_data) && is_array($arr_data)? $arr_data : ''
            );

            if($total > 0){
                return json_encode($json_data);
            }else{
                return json_encode(array("data"=>"" ));
            }

        }
        else if ( isset($request->cron) ){

            $fecha= isset($request->datatable) ? $request->rango_fecha: date('Y-m-d', strtotime('-1 days'));

            $arr['vc_evento']= 'exportando_agentes_por_hora';
            $arr['vc_info']  = $request->all();
            $this->LibCore->setSkynet( $arr );

            $data= Reporte_agentes_por_hora::select("id", "total", "hora_8", "hora_9", "hora_10"
                , "hora_11", "hora_12", "hora_13", "hora_14", "hora_15", "hora_16"
                , "hora_17", "hora_18", "hora_19", "hora_20", "hora_21")->where("fecha", $fecha );
            $total  = $data->count();

            foreach ($data->get()->take(200) as $key => $value) {
                $arr_data[]= array(!is_null($value->total) ? $value->total : ''
                                , !is_null($value->hora_8) ? intval($value->hora_8) :''
                                , !is_null($value->hora_9) ? intval($value->hora_9):''
                                , !is_null($value->hora_10) ? intval($value->hora_10):''
                                , !is_null($value->hora_11) ? intval($value->hora_11):''
                                , !is_null($value->hora_12) ? intval($value->hora_12):''
                                , !is_null($value->hora_13) ? intval($value->hora_13):''
                                , !is_null($value->hora_14) ? intval($value->hora_14):''
                                , !is_null($value->hora_15) ? intval($value->hora_15):''
                                , !is_null($value->hora_16) ? intval($value->hora_16):''
                                , !is_null($value->hora_17) ? intval($value->hora_17):''
                                , !is_null($value->hora_18) ? intval($value->hora_18):''
                                , !is_null($value->hora_19) ? intval($value->hora_19):''
                                , !is_null($value->hora_20) ? intval($value->hora_20):''
                                , !is_null($value->hora_21) ? intval($value->hora_21):''
                );
            }

            if (!isset($arr_data)){
                return false;
            }

            $title[]= array("Total" ,"8" ,"9" ,"10" ,"11" ,"12" ,"13" ,"14" ,"15" ,"16" ,"17" ,"18" ,"19" ,"20" ,"21");
            $arr_data= array_merge($title, $arr_data);

            $nombre_archivo= 'Reporte_agentes_por_hora_'.date("Y-m-d h:i:s").'.xlsx';

            $this->LibCore->crear_archivos($arr_data);

            $process = new Process( [ 'python3', public_path("/")."reporteDinamico.py" , $nombre_archivo  ] );

            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output_data = $process->getOutput();

            return $nombre_archivo;

        }
        return json_encode(array("data"=>"" ));
    }

    public function data_arr($value)
    {
        return [
                     'i_hora'=> isset($value->i_hora) ? $value->i_hora: ''
                    ,'vc_usuario'=> isset($value->vc_usuario) ? $value->vc_usuario : ''
                    ,'vc_ip'=> isset($value->vc_ip) ? $value->vc_ip : ''
                    ,'dt_fecha'=> isset($value->dt_fecha) ? $value->dt_fecha: ''
                ];
    }

    public function get_graficar_agentes_por_hora(Request $request)
    {
        $fecha= isset($request->fecha) ? $request->fecha : date('Y-m-d', strtotime('-1 days')) ;

        $data= Reporte_agentes_por_hora::select("id", "total", "hora_8", "hora_9", "hora_10"
            , "hora_11", "hora_12", "hora_13", "hora_14", "hora_15", "hora_16"
            , "hora_17", "hora_18", "hora_19", "hora_20", "hora_21")->where("fecha", $fecha)->get()->toArray();

        if (is_array($data) && !empty($data)){
            foreach ($data as $key => $value) {
                $v_grafica['name']= $value['total'] ;
                $v_data['data']= [$value['hora_8']
                    , $value['hora_9']
                    , $value['hora_10']
                    , $value['hora_11']
                    , $value['hora_12']
                    , $value['hora_13']
                    , $value['hora_14']
                    , $value['hora_15']
                    , $value['hora_16']
                    , $value['hora_17']
                    , $value['hora_18']
                    , $value['hora_19']
                    , $value['hora_20']
                    , $value['hora_21']
                ] ;

                $arr_name[]= array_merge($v_grafica, $v_data);
            }

            return json_encode($arr_name);            
        }
        
    }

    public function get_graficar_agentes_por_hora_home_office_office(Request $request)
    {
        $fecha= isset($request->fecha) ? $request->fecha : date('Y-m-d', strtotime('-1 days')) ;

        $data= Reporte_agentes_por_hora::select("id", "total", "hora_8", "hora_9", "hora_10"
            , "hora_11", "hora_12", "hora_13", "hora_14", "hora_15", "hora_16"
            , "hora_17", "hora_18", "hora_19", "hora_20", "hora_21")->where("fecha", $fecha)->take(2)->orderBy("id", "desc")->get()->toArray();

        if (is_array($data) && !empty($data)){
            foreach ($data as $key => $value) {
                $v_grafica['name']= $value['total'] ;
                $v_data['data']= [$value['hora_8']
                    , $value['hora_9']
                    , $value['hora_10']
                    , $value['hora_11']
                    , $value['hora_12']
                    , $value['hora_13']
                    , $value['hora_14']
                    , $value['hora_15']
                    , $value['hora_16']
                    , $value['hora_17']
                    , $value['hora_18']
                    , $value['hora_19']
                    , $value['hora_20']
                    , $value['hora_21']
                ] ;

                $arr_name[]= array_merge($v_grafica, $v_data);
            }

            return json_encode($arr_name);            
        }

    }

    public function cronAgentesPorHora(Request $request){

        if (!isset($request->fecha)){
            return false;
        }

        $fecha= $request->fecha;
        $total= Agentes_por_hora::where('dt_fecha', $fecha)->count();

        if ($total == 0){

            $sql= "EXEC get_agentes_por_hora @fecha='".$fecha."'";
            $consultal_srv= DB::connection('sqlsrv')->select($sql);

            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = 'Agentes por horas';
            $this->LibCore->setSkynet( $arr );

            if (is_array($consultal_srv) && !empty($consultal_srv)){

                foreach ($consultal_srv as $key => $value) {
                    $data_insert[]= $this->data_arr($value);
                    unset($data_arr);
                }

                foreach (array_chunk($data_insert,1000) as $temp)  
                {
                    DB::table('agentes_por_hora')->insert( $temp );
                }

                $sql= "CALL get_agentes_por_hora( '".$fecha."' )";
                $data = DB::select($sql);
            }
        }else{
            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = 'cronAgentesPorHora';
            $this->LibCore->setSkynet( $arr );
        }
        
    }

 
    /*
    |--------------------------------------------------------------------------
    | Realiza una busqueda hacia los servidores de SQL SERVER
    |--------------------------------------------------------------------------
    | 
    |
    */
    public function consultal_srv($Fecha)
    {
        $sql= "EXEC get_agentes_por_hora @fecha='".$Fecha."'";

        $arr['vc_evento']= 'get_agentes_por_hora ' . date("H:i:s");
        $arr['vc_info']  = $sql;
        $this->LibCore->setSkynet( $arr );

        return DB::connection('sqlsrv')->select($sql);
    }



}
