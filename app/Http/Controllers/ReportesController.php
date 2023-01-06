<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Reportes;
use App\Lib\LibCore;
use App\Models\Clientes;
use App\Models\Cat_tipificacion;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
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
    | Todo es controlado por JS reportes.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('reportes')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla reportes"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'index_reportes' , 'vc_info' => "index - reportes" ] );

        return view('reportes');
    }

    /*
    |--------------------------------------------------------------------------
    | Grafica [Tipo de cliente]
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function tipo_de_clientes()
    {
        $teiker= Clientes::where("id_cliente", "=", 0) ->where("b_status", "=", 1) ->limit(46108) ->get();
        $nuevo= Clientes::where("id_cliente", ">", 0) ->where("b_status", "=", 1) ->limit(46108) ->get();

        $data= [ 'usuario_teiker'=> $teiker->count() , 'nuevo'=> $nuevo->count() ] ;
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Grafica [Semáforo]
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function semaforo()
    {
        $atendido= Clientes::where("id_status_interaccion", "=", 1)
        ->where("b_status", "=", 1)
        ->limit(46108)
        ->get();

        $presenta_caso= Clientes::whereIn('id_status_interaccion', [2,3])
        ->where("b_status", "=", 1)
        ->limit(46108)
        ->get();

        $sin_atenderse= Clientes::whereIn('id_status_interaccion', [4])
        ->where("b_status", "=", 1)
        ->limit(46108)
        ->get();

        $data= [ 'atendido'=> $atendido->count() , 'presenta_caso'=> $presenta_caso->count() , 'sin_atenderse'=> $sin_atenderse->count() ] ;
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Grafica [tipificaciones]
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_tipificaciones(Request $request)
    {
        if ($request->get_by == "semana"){
            return $this->tipificaciones_por_semana();
        }

        if ($request->get_by == "mes"){
            // return $this->tipificaciones_mes();
        }

        if ($request->get_by == "anio"){
            // return $this->tipificaciones_anio();
        }

        $this->LibCore->setSkynet(['vc_evento'=> 'get_tipificaciones' , 'vc_info' => "request->get_by" ] );

        return json_encode(array("b_status"=> false, "data" => "Error"));
    }

    public function tipificaciones_por_mes()
    {
        $tipificaciones= Cat_tipificacion::where("b_status", "=", 1) ->get()->toArray();
        $arr_dias= [0,1,2,3,4,5,6,7,8,9,10,11];

        foreach ($tipificaciones as $key => $value) {
            $id_tipicacion= $value['id'];

            foreach ($arr_dias as $key => $dia) {

                if ( $dia == 0) {
                    $arr_tipificaciones_count[]= Clientes::select(DB::raw('COUNT(*) AS total'))
                    ->leftJoin('cat_tipificacion','cat_tipificacion.id','=','id_tipificacion')
                    ->where('id_tipificacion','=', $id_tipicacion)
                    ->where( DB::raw('DATE(clientes.created_at)'),'=',DB::raw('CURDATE()'))
                    ->where('clientes.b_status','>',0)
                    ->get()->toArray();
                }

                if ( $dia > 0){
                    $arr_tipificaciones_count[]= $this->obtener_cada_tipificacion( $id_tipicacion, $dia );
                }

                $data= $arr_tipificaciones_count;
            }

            unset($arr_tipificaciones_count);

            $arr_tipificaciones[]= ["name"=>$value['vc_tipificacion'], "data"=> $data ];
        }

        foreach ($arr_tipificaciones as $value) {
            foreach ($value["data"] as $filtrar) {
                if (isset($filtrar[0]['total'])) {
                    $arr[]= $filtrar[0]['total'];
                }
            }
            $data_final[]= ["name"=> $value["name"], "data"=> $arr];
            unset($arr);
        }
        return json_encode(array("b_status"=> true, "data" => $data_final));
    }

    public function tipificaciones_por_semana()
    {
        $tipificaciones= Cat_tipificacion::where("b_status", "=", 1) ->get()->toArray();
        $arr_dias= [0,1,2,3,4,5,6];

        foreach ($tipificaciones as $key => $value) {
            $id_tipicacion= $value['id'];

            foreach ($arr_dias as $key => $dia) {

                if ( $dia == 0) {
                    $arr_tipificaciones_count[]= Clientes::select(DB::raw('COUNT(*) AS total'))
                    ->leftJoin('cat_tipificacion','cat_tipificacion.id','=','id_tipificacion')
                    ->where('id_tipificacion','=', $id_tipicacion)
                    ->where( DB::raw('DATE(clientes.created_at)'),'=',DB::raw('CURDATE()'))
                    ->where('clientes.b_status','>',0)
                    ->get()->toArray();
                }

                if ( $dia > 0){
                    $arr_tipificaciones_count[]= $this->obtener_cada_tipificacion( $id_tipicacion, $dia );
                }

                $data= $arr_tipificaciones_count;
            }

            unset($arr_tipificaciones_count);

            $arr_tipificaciones[]= ["name"=>$value['vc_tipificacion'], "data"=> $data ];
        }

        foreach ($arr_tipificaciones as $value) {
            foreach ($value["data"] as $filtrar) {
                if (isset($filtrar[0]['total'])) {
                    $arr[]= $filtrar[0]['total'];
                }
            }
            $data_final[]= ["name"=> $value["name"], "data"=> $arr];
            unset($arr);
        }

        return json_encode(array("b_status"=> true, "data" => $data_final));
    }

    public function obtener_cada_tipificacion($id_tipicacion, $dia)
    {
        return $arr_tipificaciones_count[]= Clientes::select(DB::raw('COUNT(*) AS total'))
        ->leftJoin('cat_tipificacion','cat_tipificacion.id','=','id_tipificacion')
        ->where('id_tipificacion','=', $id_tipicacion )
        ->where( DB::raw('DATE(clientes.created_at)'),'=',DB::raw('(DATE(NOW() - INTERVAL '.$dia.' DAY))'))
        ->where('clientes.b_status','>',0)
        ->get()->toArray();
    }

    public function export(Request $request)
    {
        if ( isset($request->nombre_archivo) && Storage::exists( 'public/'.$request->nombre_archivo ) ) {
            return Storage::download('public/'.$request->nombre_archivo);
        }
    }

}


