<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Metricas_conexiones;
use App\Models\ReporteMetricasYConexiones;
use App\Lib\LibCore;
use App\Http\Controllers\TurnosController;
use App\Http\Controllers\Conexiones_metricas_formulasController;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Metricas_conexionesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;
    public $mes;

    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(){
        $this->LibCore = new LibCore();
        $this->mes = date('m');
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS metricas_conexiones.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('metricas_conexiones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla metricas_conexiones"));
        }

        $arr['vc_evento']= 'metricas_conexiones';
        $arr['vc_info']  = "index";
        $this->LibCore->setSkynet( $arr );   

        return view('metricas_conexiones');
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
    public function set_metricas_conexiones($key, $request)
    {
        if(!\Schema::hasTable('metricas_conexiones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Metricas_conexiones"));
        }

        return [ 'server_ip' => $request[$key]->server_ip,
                'fecha' => $request[$key]->Fecha,
                'user' => $request[$key]->user,
                'campaign_id' => $request[$key]->campaign_id,
                'user_group' => $request[$key]->user_group,
                'calls' => $request[$key]->calls,
                'agent_time' => $request[$key]->AGENTTIME,
                'wait' => $request[$key]->WAIT,
                'talk' => $request[$key]->TALK,
                'dispo' => $request[$key]->DISPO,
                'pausa' => $request[$key]->PAUSA,
                'ba' => $request[$key]->BA,
                'brk' => $request[$key]->BRK,
                'caling' => $request[$key]->CALING,
        ];
    }

    public function set_calculos($key, $request)
    {
        if(!\Schema::hasTable('metricas_conexiones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Metricas_conexiones"));
        }

        return [ 'server_ip' => $request[$key]->server_ip,
                'fecha' => $request[$key]->Fecha,
                'user' => $request[$key]->user,
                'campaign_id' => $request[$key]->campaign_id,
                'user_group' => $request[$key]->user_group,
                'calls' => $request[$key]->calls,
                'agent_time' => $request[$key]->AGENTTIME,
                'wait' => $request[$key]->WAIT,
                'talk' => $request[$key]->TALK,
                'dispo' => $request[$key]->DISPO,
                'pausa' => $request[$key]->PAUSA,
                'ba' => $request[$key]->BA,
                'brk' => $request[$key]->BRK,
                'caling' => $request[$key]->CALING,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_metricas_conexiones(Request $request)
    {
        if(!\Schema::hasTable('metricas_conexiones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_metricas_conexiones' , 'vc_info' => "set_import_metricas_conexiones" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['server_ip'=> trim($line)] ;
        }

        Metricas_conexiones::truncate();
        Metricas_conexiones::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
    }

    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_metricas_conexiones()
    {
        if (file_exists($this->input->post()['path']))
        {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($this->input->post()['path']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            if (is_array($sheetData) && count($sheetData) > 0)
            {
                unset($arr);
                foreach ($sheetData as $key => $value)
                {
                    if ($key > 2 && !empty($value['A']))
                    {
                        $arr[]= array(   "server_ip"  => $value['A']
                                        ,"fecha"  => $value['B']
                                        ,"user"  => $value['D']
                                        ,"campaign_id"  => $value['C']
                                        ,"user_group"  => $value['E']
                                        ,"calls"  => $value['F']
                                        ,"agent_time"  => $value['G']
                                        ,"wait"  => $value['H']
                                        ,"talk"  => $value['I']
                                        ,"dispo" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Metricas_conexiones_model->importar_metricas_conexiones($arr);
            print_r($result);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_metricas_conexiones_by_id(Request $request)
    {
        $data= Metricas_conexiones::select('server_ip'
                                    , 'fecha'
                                    , 'user'
                                    , 'campaign_id'
                                    , 'user_group'
                                    , 'calls'
                                    , 'agent_time'
                                    , 'wait'
                                    , 'talk'
                                    , 'dispo'
                                    , 'pausa'
                                    , 'ba'
                                    , 'brk'
                                    , 'caling'
        )->where('id', $request->id)->get();
        sleep(1);

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
    public function get_metricas_conexiones_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('metricas_conexiones')){
            return json_encode(array("data"=>"" ));
        }

        $data= Metricas_conexiones::select("id"
                                    , "server_ip"
                                    , "fecha"
                                    , "user"
                                    , "campaign_id"
                                    , "user_group"
                                    , "calls"
                                    , "agent_time"
                                    , "wait"
                                    , "talk"
                                    , "dispo"
                                    , 'pausa'
                                    , 'ba'
                                    , 'brk'
                                    , 'caling'
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->server_ip
                            , $value->fecha
                            , $value->user
                            , $value->campaign_id
                            , $value->user_group
                            , $value->calls
                            , $value->agent_time
                            , $value->wait
                            , $value->talk
                            , $value->dispo
                            , $value->pausa
                            , $value->ba
                            , $value->brk
                            , $value->caling
                            , $value->id
            );
        }

        $json_data = array(
            "draw"            => intval( 10 ),   
            "recordsTotal"    => intval( $total ),  
            "recordsFiltered" => intval( $total ),
            "data"            => isset($arr) && is_array($arr)? $arr : ''
        );

        if($total > 0){
            return json_encode($json_data);
        }else{
            return json_encode(array("data"=>"" ));
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
    public function delete_metricas_conexiones(Request $request)
    {
        $id=$request->id;
        Metricas_conexiones::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_metricas_conexiones(Request $request)
    {
        $id=$request->id;
        Metricas_conexiones::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_metricas_conexiones()
    {
        Metricas_conexiones::where('b_status', 1)->update(['b_status' => 0]);        
    }

    /*
    |--------------------------------------------------------------------------
    | Generar resultado 
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function generar_resultado($fecha)
    {
        $date = date_create($fecha);
        $year = date_format($date, "Y");
        $month= date_format($date, "m");
        $day  = date_format($date, "d");

        $result = DB::table('metricas_conexiones')
                ->select('metricas_conexiones.id'
                    , 'server_ip'
                    , 'fecha'
                    , 'user'
                    , 'campaign_id'
                    , 'user_group'
                    , 'calls'
                    , 'agent_time'
                    , 'wait'
                    , 'talk'
                    , 'dispo'
                    , 'pausa'
                    , 'ba'
                    , 'brk'
                    , 'caling'
                    , 'Descripcion'
                )
                ->whereRaw('YEAR(fecha) = ?',[$year])
                ->whereRaw('MONTH(fecha) = ?',[$month])
                ->whereRaw('DAY(fecha) = ?',[$day])
                ->whereNotIn('user_group', ['POSPAGO', 'CON', 'TEAML'])
                ->leftJoin('turnos', 'IdTrab', '=', 'user')
                ->orderBy('user', 'asc')
                ->get()->toArray();
        // dd($result);
        $turno= ["8:45 – 15:00 L-S"   => 9,
                "14:45 – 21:00 L-S"   => 26,
                "14:45 - 20:00 L - S" => 63,
                "14:45 - 21:00 L-V"   => 26,
                "11:00 - 21:00 L-V"   => 18,
                "08:45 – 19:00 L-V"   => 62,
                "09:00 - 18:00 L-S"   => 34,
                "10:00-20:00 L-D"     => 17
        ];

        $Proturno= ["8:45 – 15:00 L-S" => 'PT',
                "14:45 – 21:00 L-S"    => 'PT',
                "14:45 - 20:00 L - S"  => 'PT',
                "14:45 - 21:00 L-V"    => 'PT',
                "11:00 - 21:00 L-V"    => 'FT',
                "08:45 – 19:00 L-V"    => 'FT',
                "09:00 - 18:00 L-S"    => 'FT',
                "10:00-20:00 L-D"      => 'FT'
        ];

        $get_agentes = DB::table('turnos')->select('IdTrab', 'Descripcion')
        ->whereNotIn('Centro_Costo', ['MUEVETE POSPAGO'])
        ->get()->toArray();

        if (is_array($get_agentes) && !empty($get_agentes)){

            foreach ($get_agentes as $key => $value) {

                if ( isset($Proturno[$value->Descripcion]) && $Proturno[$value->Descripcion] == "FT" ){
                    $agentes_hc_ft[]= $Proturno[$value->Descripcion];
                }

                if (isset($Proturno[$value->Descripcion]) && $Proturno[$value->Descripcion] == "PT"){
                    $agentes_hc_pt[]= $Proturno[$value->Descripcion];
                }
            }
        }

        $fecha= isset( $result[0]->fecha ) ? $result[0]->fecha : '' ;

        foreach ($result as $key => $value) {

            $agent_time= $value->agent_time;
            $wait_calling= $this->LibCore->sum_time($result[$key]->wait, $result[$key]->caling);
            $wait_calling_login_time = $this->LibCore->decimal( $wait_calling ) / $this->LibCore->decimal( $agent_time ) * 100;

            $tiempo_entre_llamadas =  $value->calls > 0 ? $this->LibCore->div_hora($wait_calling  , $value->calls) : '' ;
            $break_banio= $this->LibCore->sum_time($result[$key]->ba, $result[$key]->brk);
            $break_banio_login_time= $this->LibCore->decimal ( $break_banio ) / $this->LibCore->decimal ( $agent_time ) * 100;
            $talk= $this->LibCore->hora_a_minutos( $value->talk ) / $this->LibCore->hora_a_minutos( $value->agent_time ) * 100;
            $llamadas_por_hora_promedio=  number_format((float) $value->calls / $this->LibCore->hora_a_minutos($agent_time), 2, '.', '') ;

            $horaInicio = new \DateTime($agent_time);
            $horaTermino = new \DateTime($value->pausa);
            $interval = $horaInicio->diff($horaTermino);
            $resta    = $interval->format('%H:%i:%s');
            $billable= $this->LibCore->sum_time($resta, $value->caling);

            $data[]= [
              'user'=> $value->user
            , 'wait_calling'=> $wait_calling
            , 'wait_calling_login_time'=> number_format((float) $wait_calling_login_time, 2, '.', '')
            , 'tiempo_entre_llamadas'=> $tiempo_entre_llamadas
            , 'break_banio'=> $break_banio
            , 'break_banio_login_time'=> number_format((float) $break_banio_login_time, 2, '.', '')
            , 'llamadas_por_hora_promedio'=> $llamadas_por_hora_promedio
            , 'talk'=> round($talk) 
            , 'billable'=>  $billable
            , 'billable_entre_tiempo'=>  round($this->LibCore->hora_a_minutos($billable) / $this->LibCore->hora_a_minutos($agent_time) * 100)  
            , 'decimal'=>  number_format((float) $this->LibCore->hora_a_minutos( $billable ) / $this->LibCore->hora_a_minutos( "01:00:00" ), 2, '.', '')
            , 'rol'=> !empty($turno[$value->Descripcion]) ? $turno[$value->Descripcion] : ''
            , 'proTurno'=> !empty($Proturno[$value->Descripcion]) ? $Proturno[$value->Descripcion] : ''
            ];

            $x= !empty($Proturno[$value->Descripcion]) ? $Proturno[$value->Descripcion] : '';
            $y= !empty($turno[$value->Descripcion]) ? $turno[$value->Descripcion] : '';
        }

        foreach ($data as $key => $value) {
            $arrProTurno[]= $value['proTurno'];
        }

        $totalProTurno= array_count_values($arrProTurno);
        unset($totalProTurno['']);

        foreach ($data as $key => $value) {
            $a[]= $value['decimal'];
        }

        $horas_r= array_sum( $a );
        $horas_r= number_format( (float) $horas_r, 1, '.', '' );

        $horas_agentes= '';
        foreach ($data as $key => $value) {
            $horas_agentes.=  $value['billable'].', ';
        }

        unset($result);
        $result['horas_r']= $horas_r;
        $result['promedio_billiable_x_agente']= $this->LibCore->promedio_horas( $horas_agentes );
        $result['agentes_conectados_ft']= $totalProTurno['FT'];
        $result['agentes_conectados_pt']= $totalProTurno['PT'];
        $result['total1']= $totalProTurno['FT'] + $totalProTurno['PT']; // okk

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $result['agentes_hc_ft']= count($agentes_hc_ft);
        $result['agentes_hc_pt']= count($agentes_hc_pt);
        $result['horas_max_ft']= $totalProTurno['FT'] * 9;
        $result['horas_max_pt']= $totalProTurno['PT'] * 6;
        $result['total2']= $result['horas_max_pt'] + $result['horas_max_ft'];

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $arr_ft='';
        $arr_fp='';
        foreach ($data as $key => $value) {
            if ($value['proTurno'] == 'FT'){
                $arr_ft.= $value['billable'] . ",";
            }

            if ($value['proTurno'] == 'PT'){
                $arr_fp.= $value['billable'] . ",";
            }
        }

        $result['hrs_fac_ft']= $this->LibCore->sumar_horas( strval( mb_substr($arr_ft, 0, -1) ) ) ;
        $result['hrs_fac_pt']= $this->LibCore->sumar_horas( strval( mb_substr($arr_fp, 0, -1) ) );


        $result['total_hr_ft']= count($agentes_hc_ft) * 9 ;
        $result['total_hr_pt']= count($agentes_hc_pt) * 6 ;
        $result['obj_hrs_hc']= count($agentes_hc_ft) * 9 + count($agentes_hc_pt) * 6;
        $result['faltas']= (count($agentes_hc_ft) + count($agentes_hc_pt)) - ($totalProTurno['FT'] + $totalProTurno['PT']);


        $result['tope_de_hrs_x_dia']= $result['total2'];
        $result['hrs_fact']= $result['hrs_fac_ft'] + $result['hrs_fac_pt'];
        $result['dif_hrs_top']= $result['hrs_fact'] - $result['tope_de_hrs_x_dia'];
        $result['fac_hrs_tope']= ($result['hrs_fact'] / $result['tope_de_hrs_x_dia']) * 100;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $result['DIFERENCIA_HRS_HC']= $result['hrs_fact'] - $result['obj_hrs_hc'];
        $result['FACT_HRS_TOPE__HRS_FACT_REALES']= ($result['hrs_fact'] / (count($agentes_hc_ft) * 9 + count($agentes_hc_pt) * 6)) * 100;

        $arr_data_insert['fecha']= $fecha;
        $arr_data_insert['horas_r']= $result['horas_r'];
        $arr_data_insert['promedio_billiable_x_agente']= $result['promedio_billiable_x_agente'];
        $arr_data_insert['faltas']= $result['faltas'];
        $arr_data_insert['tope_de_hrs_x_dia']= $result['tope_de_hrs_x_dia'];
        $arr_data_insert['hrs_fact']= $result['hrs_fact'];
        $arr_data_insert['dif_hrs_top']= $result['dif_hrs_top'];
        $arr_data_insert['fac_hrs_tope']= $result['fac_hrs_tope'];
        $arr_data_insert['DIFERENCIA_HRS_HC']= $result['DIFERENCIA_HRS_HC'];
        $arr_data_insert['FACT_HRS_TOPE__HRS_FACT_REALES']= $result['FACT_HRS_TOPE__HRS_FACT_REALES'];

        $exists= ReporteMetricasYConexiones::where('fecha', '=', $fecha)->count();
        
        if ($exists == 0){
            ReporteMetricasYConexiones::create($arr_data_insert);
        }

        return $result;
    }

    public function get_reporte_metricas_y_conexiones(){
        $query= ReporteMetricasYConexiones::whereRaw('MONTH(fecha) = ?',[$this->mes])->orderby("fecha","asc")->get()->toArray();

        foreach ($query as $key => $value) {

            $fecha_bd= $value['fecha'];
            $day= date_create($fecha_bd);
            $day= date_format($day, "D");

            if ($day == "Sat"){
                $Sun= ["id"=> "",
                "fecha"=> date('Y-m-d', strtotime($value['fecha']. ' + 1 days')),
                "horas_r"=> "0.0",
                "promedio_billiable_x_agente"=> "",
                "faltas"=> "0",
                "tope_de_hrs_x_dia"=> "0.0",
                "hrs_fact"=> "0.0",
                "dif_hrs_top"=> "0.0",
                "fac_hrs_tope"=> "",
                "DIFERENCIA_HRS_HC"=> "0.0",
                "FACT_HRS_TOPE__HRS_FACT_REALES"=> ""];
                $arr[]= array_merge($Sun);
            }

            $arr[]= ["id"=> $value['id'],
                "fecha"=> $value['fecha'],
                "horas_r"=> $value['horas_r'],
                "promedio_billiable_x_agente"=> $value['promedio_billiable_x_agente'],
                "faltas"=> $value['faltas'],
                "tope_de_hrs_x_dia"=> $value['tope_de_hrs_x_dia'],
                "hrs_fact"=> $value['hrs_fact'],
                "dif_hrs_top"=> $value['dif_hrs_top'],
                "fac_hrs_tope"=> number_format( (float) $value['fac_hrs_tope'], 1, ".", "" ) ." %",
                "DIFERENCIA_HRS_HC"=> $value['DIFERENCIA_HRS_HC'],
                "FACT_HRS_TOPE__HRS_FACT_REALES"=> number_format( (float) $value['FACT_HRS_TOPE__HRS_FACT_REALES'],1 , ".", "") . " %"
            ];

            $sum[]= $value['hrs_fact'] ;
        }

        usort($arr, fn ($a, $b) => strtotime($a["fecha"]) - strtotime($b["fecha"]));

        $real_minimo= round(array_sum($sum));

        $objetivo_minimo['objetivo_minimo_hrs']=  900 * 26 ;
        $moneda= $objetivo_minimo['objetivo_minimo_hrs'] *  96.2;
        $objetivo_minimo['objetivo_minimo_mensual']= "$ ".str_replace('.', ',', number_format($moneda, 0, ",", ".")).".00" ;
        $objetivo_minimo['real_minimo_hrs']=  number_format( (float) $real_minimo, 0, "","" ) ;
        $real_moneda= $objetivo_minimo['real_minimo_hrs'] * 96.2;
        $objetivo_minimo['real_minimo_facturacion']=  "$ ".str_replace('.', ',', number_format($real_moneda, 0, ",", ".")).".00" ;
        $objetivo_minimo['diff_minimo_hrs']=  $objetivo_minimo['real_minimo_hrs']- $objetivo_minimo['objetivo_minimo_hrs'];
        $objetivo_minimo['diff_minimo_mensual']= "$ ".str_replace('.', ',', number_format($real_minimo - $moneda, 0, ",", ".")).".00" ;
        $objetivo_minimo['porcentaje']= round($moneda / $real_moneda) . "%";

        $objetivo_ideal['objetivo_ideal_hrs']=  1200 * 26 ;
        $moneda= $objetivo_ideal['objetivo_ideal_hrs'] *  96.2;
        $objetivo_ideal['objetivo_ideal_mensual']= "$ ".str_replace('.', ',', number_format($moneda, 0, ",", ".")).".00" ;
        $objetivo_ideal['real_minimo_hrs']=  number_format( (float) $real_minimo, 0, "","" ) ;
        $real_moneda= $objetivo_ideal['real_minimo_hrs'] * 96.2;
        $objetivo_ideal['real_minimo_facturacion']=  "$ ".str_replace('.', ',', number_format($real_moneda, 0, ",", ".")).".00" ;
        $objetivo_ideal['diff_minimo_hrs']=  $objetivo_ideal['real_minimo_hrs']- $objetivo_ideal['objetivo_ideal_hrs'];
        $objetivo_ideal['diff_minimo_mensual']= "$ ".str_replace('.', ',', number_format($real_minimo - $moneda, 0, ",", ".")).".00" ;
        $objetivo_ideal['porcentaje']= round($moneda / $real_moneda) . "%";

        $arr= ['table'=> $arr];
        $arr= array_merge($arr, ['objetivo_minimo'=> $objetivo_minimo], ['objetivo_ideal'=> $objetivo_ideal]);
        return json_encode($arr);
    }

    public function generarReporteExcel(){
        $arr_data= $this->get_reporte_metricas_y_conexiones();

        $this->LibCore->if_exists_sp('get_asistencias', true);
        $sql= "CALL get_asistencias()";
        $data = DB::select($sql);

        $dia = $this->LibCore->restar_dia(-1);

        $arr_data = array_merge(json_decode($arr_data, true), ['asistencias'=> $data], ['dia' => strtoupper($dia)] );

        $nombre_archivo= 'Reporte_metricas_conexiones.xlsx';
        $this->LibCore->crear_archivos( $arr_data );

        $process = new Process( [ 'python3', public_path("/")."metricas_conexiones.py" , $nombre_archivo  ] );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = $process->getOutput();

        return $nombre_archivo;
    }

    public function cronMetricasConexiones(){

        $fecha= date('Y-m-d', strtotime('-1 days'));
        $total= Metricas_conexiones::where('fecha', $fecha)->count();

        if ( $total == 0 ){
            $sql= "EXEC get_metricas_y_conexiones @FechaInicial='".$fecha."', @FechaFinal='".$fecha."' ";

            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = 'METRICAS Y CONEXIONES';
            $this->LibCore->setSkynet( $arr ); 

            $result= DB::connection('sqlsrv')->select($sql);

            if (!empty($result)){
                foreach ($result as $key => $value) {
                    $data_insert[]= $this->set_metricas_conexiones($key, $result);
                }

                foreach (array_chunk($data_insert,1000) as $temp)  
                {
                    DB::table('metricas_conexiones')->insert( $temp );
                }

                unset($result);
                unset($data_insert);

                $sql= "exec get_metricas_y_conexiones_turnos_proactivas";
                $result= DB::connection('sqlsrv')->select($sql);
                DB::table('turnos')->truncate();

                foreach ($result as $key => $value) {
                    $data_insert[]= (new TurnosController)->set_turnos($key, $result);
                }

                foreach (array_chunk($data_insert,1000) as $temp)  
                {
                    DB::table('turnos')->insert( $temp );
                }

                $this->generar_resultado($fecha);
            }
        }else{
            $arr['vc_evento']= 'init_cron';
            $arr['vc_info']  = 0;
            $this->LibCore->setSkynet( $arr );             
        }
    }
}
