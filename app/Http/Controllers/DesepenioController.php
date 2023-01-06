<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Desepenio;
use App\Models\Jefepisos;
use App\Models\Empleado;
use App\Models\Reporteproductividad;
use App\Models\Reportventas3;
use App\Models\Reportventas2;
use App\Models\Reportventas1;
use App\Lib\LibCore;

class DesepenioController extends Controller
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
    | Todo es controlado por JS desepenio.js
    |
    */
    public function index()
    {

        if(!\Schema::hasTable('desepenio')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla desepenio"));
        }
        // $this->LibCore->setSkynet( ['vc_evento'=> 'index_desepenio' , 'vc_info' => "index - desepenio" ] );

        return view('desepenio');
    }


    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_desepenio_by_datatable(Request $request)
    {
        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );
        $sql= "EXEC get_desempenio @FechaInicial='".$fecha['dt_ini']."', @FechaFinal='".$fecha['dt_fin']."'";

        $consultal_srv= DB::connection('sqlsrv')->select($sql);
        foreach ($consultal_srv as $key => $value) {
            $arr_data[]= [  $value->IdTrab,
                            $value->Gestor,
                            $value->Ingreso,
                            $value->Baja,
                            $value->Ant,
                            $value->Turno,
                            $value->Rol,
                            $value->Descripcion,
                            $value->Departamento,
                            $value->Supervisor,
                            $value->Jefe_Piso,
                            $value->HORAS_MES,
                            $value->TIEMPO_EFECTIVO,
                            $value->TIEMPO_EFECTIVO,
                            $value->SPH_MES,
                            $value->LOGROS_MES,
                        ];           
        }

        $total= 10000;
        $json_data = array(
            "draw"            => intval( 10000 ),   
            "recordsTotal"    => intval( $total ),  
            "recordsFiltered" => intval( $total ),
            "data"            => isset($arr_data) && is_array($arr_data) ? $arr_data : ''
        );

        if($total > 0){
            return json_encode($json_data);
        }else{
            return json_encode(array("data"=>"" ));
        }        
    }

    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_desepenio()
    {
        Skynet::truncate();
    }

    public function detallesDesempeno(Request $request){
        $fecha= $this->fecha( isset($request->rango_fecha) ? $request->rango_fecha : '' );
        
        $dt1 = date("Y-m-d");
        $dt_ini = date( "Y-m-d", strtotime( "$dt1 -30 day" ) );
        $dt_fin = $dt1;

        $inicio = isset($fecha['dt_ini']) && !empty($fecha['dt_ini']) ? $fecha['dt_ini'] : $dt_ini;
        $final  = isset($fecha['dt_fin']) && !empty($fecha['dt_fin']) ? $fecha['dt_fin'] : $dt_fin;

        $timesourceArray = array();

        $reporte1 = Reportventas1::select("fecha", "user_id")
            ->selectRaw("SEC_TO_TIME( SUM(TIME_TO_SEC(date_format(agent_time, '%h:%m:%s')))) as totalAgent")
            ->selectRaw("SEC_TO_TIME( SUM(TIME_TO_SEC(date_format(Horas_Efectivas, '%h:%m:%s')))) as totalHoras")
            ->whereBetween('fecha', [$inicio, $final])->groupBy("user_id")->get();

        foreach ($reporte1 as $key => $rep1) {

            $reporte3 = Reportventas3::select(
                "report_performance_ventas_3.fecha", 
                "report_performance_ventas_3.user_id", 
                "report_performance_ventas_3.Nombre_Completo", 
                'report_performance_ventas_3.Ingreso', 
                'report_performance_ventas_3.Baja', 
                'report_performance_ventas_3.Ant', 
                'report_performance_ventas_3.Turno', 
                'report_performance_ventas_3.Rol', 
                'report_performance_ventas_3.Centro_Costo', 
                'report_performance_ventas_3.Puesto', 
                'report_performance_ventas_3.Departamento', 
                'jefepisos.jefe_piso', 
                'jefepisos.supervisor')
            ->join('jefepisos', 'jefepisos.departamento', '=', 'report_performance_ventas_3.Departamento')
            ->where('report_performance_ventas_3.user_id', '=', $rep1->user_id )
            ->first();

            $reporte2 = Reportventas2::select("ventas", "user_id") 
            ->selectRaw("SUM(ventas) as totalVentas")
                ->whereBetween('fecha', [$inicio, $final])
                ->where('user_id', '=', $rep1->user_id )
                ->groupBy("user_id")->first();

                if(isset($reporte2->totalVentas)){
                    $totalVentas = $reporte2->totalVentas;
                }else{
                    $totalVentas = 0;
                }

                $date = $rep1->totalHoras;
                $date2 = $rep1->totalAgent;

                $oldDate = explode(":", $date);
                $oldDate2 = explode(":", $date2);

                $oldDate_int = ($oldDate[0] * 3600) + ($oldDate[1] * 60) + ($oldDate[2]);
                $oldDate_int2 = ($oldDate2[0] * 3600) + ($oldDate2[1] * 60) + ($oldDate2[2]);

                $time_int = $oldDate_int2 / $oldDate_int;

                $time_int2 = 2 / ($oldDate_int / 3600);

                $porcentajeTiempo = round($time_int * 100, 2);

                $sph = ($totalVentas / ($oldDate_int / 3600));

                $format_sph = number_format($sph, 2);
            
            if(isset($reporte3->Nombre_Completo)){
                $detalles = array(
                    $reporte3->user_id,
                    $reporte3->Nombre_Completo,
                    $reporte3->Ingreso,
                    $reporte3->Baja,
                    $reporte3->Ant,
                    $reporte3->Turno,
                    $reporte3->Rol,
                    $reporte3->Centro_Costo,
                    $reporte3->Departamento,
                    $reporte3->supervisor,
                    $reporte3->jefe_piso,
                    $rep1->totalAgent,
                    $rep1->totalHoras,
                    $totalVentas,
                    $porcentajeTiempo,
                    $format_sph,
                );
            }

            array_push($timesourceArray, $detalles);
       
        }

        return $timesourceArray;
    }


    public function teamgreen(){

        $jefes = Jefepisos::select("jefepisos.jefe_piso", "jefepisos.supervisor", "jefepisos.departamento", 'metascampanas.meta')
                        ->join('metascampanas', 'jefepisos.id', '=', 'metascampanas.id_jefepisos')
                        ->get();        
        return $jefes;
    }

    public function crear_archivos($arr)
    {
        // Archivo donde se guardan los datos para formar el Excel
        if (Storage::exists('public/json_data.json')){
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }else{
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }
    }

    public function eliminar_archivo_ya_exportado(Request $request)
    {
        sleep(10);

        if ( isset($request->nombre_archivo) && Storage::exists( 'public/'.$request->nombre_archivo )){

            $status_delete= Storage::delete( 'public/'.$request->nombre_archivo );

            $this->LibCore->setSkynet( [  'vc_evento'=> 'eliminar_archivo_ya_exportado_1' 
                                        , 'vc_info'  => 'public/'.$request->nombre_archivo  ."\n<b>status_delete:</b>".$status_delete
            ] );

            return $request->nombre_archivo;

        }else{

            $this->LibCore->setSkynet( [ 'vc_evento'=> 'eliminar_archivo_ya_exportado_0' 
                                        ,'vc_info'  => '<b>No se encontro el Archivo</b> <br>' 
            ] );

        }
    }

    public function export(Request $request)
    {
        if ( isset($request->nombre_archivo) && Storage::exists( 'public/'.$request->nombre_archivo ) ) {
            return Storage::download('public/'.$request->nombre_archivo);
        }
    }

    public function calendar_desempeno(Request $request){

        $fecha= $this->fecha( isset($request->rango_fecha) ? $request->rango_fecha : '' );

        $dt1 = date("Y-m-d");
        $dt2 = date( "Y-m-d", strtotime( "$dt1 -30 day" ) );

        $inicio = isset($fecha['dt_ini']) && !empty($fecha['dt_ini']) ? $fecha['dt_ini'] : $dt1;
        $final  = isset($fecha['dt_fin']) && !empty($fecha['dt_fin']) ? $fecha['dt_fin'] : $dt2;

        $arrayDetalles   = array();

        $reporte1 = Reportventas1::select("fecha", "user_id", "agent_time", "brk", "jun", "ba", "Horas_Efectivas", "Promedio TIempo_Efectivo as Promedio")
            ->whereBetween('fecha', [ $final, $inicio])
            ->where('user_id', '=', $request->idtrab )
            ->orderBy('fecha', 'asc')
            ->get();

        foreach ($reporte1 as $detalle) {

            $reporte2 = Reportventas2::select("ventas", "user_id") 
                ->selectRaw("SUM(ventas) as totalVentas")
                ->whereBetween('fecha', [$inicio, $final])
                ->where('user_id', '=', $request->idtrab )
                ->groupBy("user_id")->first();

            if(isset($reporte2->totalVentas)){
                $totalVentas = $reporte2->totalVentas;
            }else{
                $totalVentas = 0;
            }

            $date = $detalle->agent_time;
            $oldDate = explode(":", $date);
            $oldDate_int = ($oldDate[0] * 3600) + ($oldDate[1] * 60) + ($oldDate[2]);
            $sph = ($totalVentas / ($oldDate_int / 3600));
            $format_sph = number_format($sph, 2);

            //quitamos los ceros
            $agent_time = explode(".", $detalle->agent_time);
            $brk = explode(".", $detalle->brk);
            $jun = explode(".", $detalle->jun);
            $ba = explode(".", $detalle->ba);
            $Horas_Efectivas = explode(".", $detalle->Horas_Efectivas);

            $arrDetalles = array(
                $detalle->fecha,
                $detalle->user_id,
                $agent_time[0],
                $totalVentas,
                $format_sph,
                $brk[0],
                $jun[0],
                $ba[0],
                $Horas_Efectivas[0],
                $detalle->Promedio,
            );

            array_push($arrayDetalles, $arrDetalles);
        }


        $total= 10000;

        $json_data = array(
            "draw"            => intval( 10000 ),   
            "recordsTotal"    => intval( $total ),  
            "recordsFiltered" => intval( $total ),
            "data"            => isset($arrayDetalles) && is_array($arrayDetalles) ? $arrayDetalles : ''
        );

        if( is_array($arrayDetalles) && count($arrayDetalles) > 0 ){
            return json_encode($json_data);
        }else{
            return json_encode(array("data"=>"" ));
        }
      
    }


    /*
    |--------------------------------------------------------------------------
    | Extraer Fechas
    |--------------------------------------------------------------------------
    | 
    */
    public function fecha($dt)
    {
        $dt= explode('to', $dt);
        $dt_ini= $dt[0];
        $dt_fin= count($dt) > 1 ? $dt[1]: $dt[0];

        return [ 'dt_ini' => $dt_ini, 'dt_fin' => $dt_fin];
    }

    public function generarReporteExcelDesempenio(Request $request){

        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );
        $sql= "EXEC get_desempenio @FechaInicial='".$fecha['dt_ini']."', @FechaFinal='".$fecha['dt_fin']."'";

        $consultal_srv= DB::connection('sqlsrv')->select($sql);
        foreach ($consultal_srv as $key => $value) {
            $arr_data[]= [  $value->IdTrab,
                            $value->Gestor,
                            $value->Ingreso,
                            $value->Baja,
                            $value->Ant,
                            $value->Turno,
                            $value->Rol,
                            $value->Descripcion,
                            $value->Departamento,
                            $value->Supervisor,
                            $value->Jefe_Piso,
                            $value->HORAS_MES,
                            $value->TIEMPO_EFECTIVO,
                            $value->SPH_MES,
                            $value->LOGROS_MES,
                        ];           
        }
        $nombre_archivo= 'Reporte_de_Desempenio.xlsx';

        $title[]= ["IdTrab", "Gestor", "Ingreso", "Baja", "Ant", "Turno", "Rol", "Descripción", "Departamento", "Coordinador", "Jefe Piso", "HORAS MES ∑", "TIEMPO EFECTIVO ∑", "SPH MES ∑", "LOGROS MES ∑", ];

        $arr_data= array_merge($title, $arr_data);

        $this->LibCore->crear_archivos( $arr_data );

        $process = new Process( [ 'python3', public_path("/")."desempenio.py" , $nombre_archivo  ] );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = $process->getOutput();

        return $nombre_archivo;
    }


}
