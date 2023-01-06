<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Cortes_por_hora;
use App\Lib\LibCore;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Cortes_por_horaController extends Controller
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
    | Todo es controlado por JS cortes_por_hora.js
    |
    */
    public function index()
    {

        // $date = Carbon::now()->locale('es');
        // $date = Carbon::parse('15 Dec')->locale('es');

        // echo $date->monthName;return;

        if(!\Schema::hasTable('cortes_por_hora')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla cortes_por_hora"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_cortes_por_hora' , 'vc_info' => "index - cortes_por_hora" ] );

        return view('cortes_por_hora');
    }

    /*
    |--------------------------------------------------------------------------
    | Agrega o modificar registro
    |--------------------------------------------------------------------------
    | 
    | Modifica el registro solo si manda el parametro '$request->id'
    | @return json
    |
    */
    public function set_cortes_por_hora($value)
    {
        if(!\Schema::hasTable('cortes_por_hora')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cortes_por_hora"));
        }

        return [     'event_date'=> isset($value->event_date) ? $value->event_date: ''
                    ,'interval_hour'=> isset($value->interval_hour) ? $value->interval_hour : ''
                    ,'agenttime_time'=> isset($value->agenttime_time) ? $value->agenttime_time : ''
                    ,'sales'=> isset($value->sales) ? $value->sales: ''
                    ,'SPH'=> isset($value->SPH) ? $value->SPH: ''
                ];        

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_cortes_por_hora(Request $request)
    {
        if(!\Schema::hasTable('cortes_por_hora')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_cortes_por_hora' , 'vc_info' => "set_import_cortes_por_hora" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['event_date'=> trim($line)] ;

        }

        Cortes_por_hora::truncate();
        Cortes_por_hora::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
    }



    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cortes_por_hora_by_id(Request $request)
    {
        $data= Cortes_por_hora::select('event_date'
                                    , 'interval_hour'
                                    , 'agenttime_time'
                                    , 'sales'
                                    , 'SPH'
        )->where('id', $request->id)->get();

        if ( $data->count() > 0 ){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" => 'sin resultados'));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cortes_por_hora_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('cortes_por_hora')){
            return json_encode(array("data"=>"" ));
        }

        $v_rango_fechas= $this->LibCore->getSinDomingo(7, 'Y-m-d');

        foreach (array_reverse($v_rango_fechas) as $key => $value) {
            $dt_ini= $value; break;
        }

        foreach ($v_rango_fechas as $key => $value) {
            $dt_fin= $value; break;
        }

        if (isset($request->rango_fecha) && !empty($request->rango_fecha)){
            $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );
            $dt_ini= $fecha['dt_ini'];
            $dt_fin= $fecha['dt_fin'];

            $dt_fin = new \DateTime($dt_fin.' +1 day');
            $dt_fin = date_format($dt_fin,"Y-m-d");

            $period = new \DatePeriod(
                 new \DateTime($dt_ini),
                 new \DateInterval('P1D'),
                 new \DateTime($dt_fin)
            );

            unset($v_rango_fechas);

            foreach ($period as $key => $value) {
                $v_rango_fechas[$value->format('d M')]= $value->format('Y-m-d');
            }
        }

        $data= $this->fn_exists($dt_ini, $dt_fin);
        $total= $data->count();

        if ($total== 0){
            $request->merge(['dt_ini' => $dt_ini, 'dt_fin' => $dt_fin ]);
            $this->cronCortesPorHora($request);
            $data= $this->fn_exists($dt_ini, $dt_fin);
            $total= $data->count();
        }

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array( "interval_hour"=> $value->interval_hour
                    , "sales"=> $value->sales
                    , "event_date"=> $value->event_date
                    , "interval_hour"=> $value->interval_hour
                    , "agenttime_time"=> $value->agenttime_time
                );
            }

            foreach ($v_rango_fechas as $key0 => $value0) {

                foreach ($arr as $key1 => $value1) {

                    if ( $value1['event_date'] == $value0 ){
                        $arr_datos[]= $value1;
                        $sumar_hrs[]= $value1['agenttime_time'];
                        $v_total_hrs[]= $value1['sales'];                        
                    }
                }

                if (isset($arr_datos)){

                    $arrr_hrs='';
                    foreach ($sumar_hrs as $key9 => $value9) {
                        $arrr_hrs.= $value9. ",";
                    }

                    unset($total__hrs);

                    $total__hrs=$this->LibCore->sumar_tiempo( strval( mb_substr($arrr_hrs, 0, -1) ) );
                    $v_total_hrs= array_sum($v_total_hrs);
                    $total__hrs= round($total__hrs);

                    if ($v_total_hrs > 0 && $total__hrs > 0){
                        $sph= number_format( (float) (intval($v_total_hrs) / intval($total__hrs)), 3, ".", "");
                    }else{
                        $sph='';
                    }
            
                    $date = Carbon::parse($key0)->locale('es');

                    $datos[]= array_merge( [ "fecha"=> $date->day." ".Str::ucfirst($date->shortMonthName) ]
                                            , ["datos"=> $arr_datos, "v_hrs"=> $total__hrs, "v_total_hrs"=> $v_total_hrs, 'sph'=> $sph  ] 
                    );
                    unset($arr_datos, $arrr_hrs, $sumar_hrs, $v_total_hrs, $sph);
                }
            }

            return json_encode( array("b_status"=> true, 'data'=> isset($datos) ? $datos :'Sin dantos...' ) );

        }else{
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontraron registros"));
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar registro por id
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function delete_cortes_por_hora(Request $request)
    {
        $id=$request->id;
        Cortes_por_hora::where('id', $id)->update(['b_status' => 0]);
        return $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Desahacer el registro que se elimino
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function undo_delete_cortes_por_hora(Request $request)
    {
        $id=$request->id;
        Cortes_por_hora::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }


    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_cortes_por_hora()
    {
        Cortes_por_hora::where('b_status', 1)->update(['b_status' => 0]);        
    }

    public function cronCortesPorHora(Request $request){

        $dt_ini= date("Y-m-d");
        $dt_fin= $dt_ini;

        if (isset($request->rango_fecha)){
            $dt_ini= $request->dt_ini;
            $dt_fin= $request->dt_fin;
        }

        $sql= "EXEC get_cortes_por_hora @fecha_inicial='".$dt_ini."', @fecha_final='".$dt_fin."' ";
        $consultal_srv= DB::connection('sqlsrv')->select($sql);

        $arr['vc_evento']= 'init_cron';
        $arr['vc_info']  = 'CORTES POR HORAS';
        $this->LibCore->setSkynet( $arr );

        if (is_array($consultal_srv) && !empty($consultal_srv)){

            foreach ($consultal_srv as $key => $value) {
                $data_insert[]= $this->set_cortes_por_hora($value);
            }

            $arr['vc_evento']= 'data_insert';
            $arr['vc_info']  = $data_insert;
            $this->LibCore->setSkynet( $arr );

            // borrar la fecha a consultar para evitar duplicidad
            $sql= 'delete from cortes_por_hora where event_date between "'.$dt_ini.'" AND "'.$dt_fin.'" ';
            DB::delete($sql);

            $arr['vc_evento']= 'delete';
            $arr['vc_info']  = $sql;
            $this->LibCore->setSkynet( $arr );

            foreach (array_chunk($data_insert,1000) as $temp)  
            {
                DB::table('cortes_por_hora')->insert( $temp );
            }

        }
    }

    public function fn_exists($dt_ini, $dt_fin){

        $data= Cortes_por_hora::select("interval_hour", "sales", "event_date", "interval_hour", "agenttime_time")
        ->whereBetween('event_date', [ $dt_ini, $dt_fin ])
        ->where('b_status', 1)->orderBy("event_date", "desc")->get();

        return $data;
    }

}
