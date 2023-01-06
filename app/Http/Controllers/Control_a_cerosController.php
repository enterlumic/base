<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';

use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Control_a_ceros;
use App\Models\Reportventas5;
use App\Models\Reportventas4;
use App\Models\Reportventas3;
use App\Models\Reportventas2;
use App\Models\Reportventas1;
use App\Lib\LibCore;
use App\Http\Controllers\DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend as ChartLegend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate as CoordinateCell;

class Control_a_cerosController extends Controller
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
    | Todo es controlado por JS control_a_ceros.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_control_a_ceros' , 'vc_info' => "index - control_a_ceros" ] );
        return view('control_a_ceros');
    }

    public function test(Request $request)
    {
        $FechaInicial="2022-10-01";
        $FechaFinal="2022-10-29";

        $sql= "EXEC Report_carrier_stats_ventas @FechaInicial='".$FechaInicial."', @FechaFinal='".$FechaFinal."'";
        $plantilla_cero= DB::connection('sqlsrv')->select($sql);
        dd($plantilla_cero);
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    |
    | @return json
    |
    */
    public function get_control_a_ceros_by_datatable(Request $request)
    {
        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );

        if (is_null($request->rango_fecha)){

            $v_rango_fechas= $this->getLastNDays(7, 'Y-m-d');

            foreach ($v_rango_fechas as $key => $value) {
                $fecha_inicial= $value; break;
            }

            foreach (array_reverse($v_rango_fechas) as $key => $value) {
                $fecha_final= $value; break;
            }

            return "No se encontro registros ".$fecha_inicial." del ".$fecha_final." Enviar fecha despues del 2022-10-12";

            $arr['vc_evento']= 'Fecha sin Personalizar ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $request->all(), JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        }else{
            $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $fecha, JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $v_rango_fechas= $this->f_rango_fechas( $fecha['dt_ini'], $fecha['dt_fin'] );
        }

        foreach ($v_rango_fechas as $key => $value) {
            $fecha_inicial= $value; break;
        }

        foreach (array_reverse($v_rango_fechas) as $key => $value) {
            $fecha_final= $value; break;
        }

        try {
            $sql= "EXEC get_control_a_ceros @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $plantilla_cero= DB::connection('sqlsrv')->select($sql);

            $arr['vc_evento']= 'Control a ceros Plantilla ' . date("H:i:s");
            $arr['vc_info']  = $sql ." \n Registros: ". count($plantilla_cero);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        } catch (Exception $e) {

        }

        if ( is_array($plantilla_cero) && count($plantilla_cero) > 0 ) {
            foreach ($plantilla_cero as $key => $value) {
                $array_data[]= [  "IdTrab" => $value->IdTrab
                                , "Nombre_Completo" => $value->Gestor
                                , "Ingreso" => $value->Ingreso
                                , "Baja" => $value->Baja
                                , "Ant" => $value->Ant
                                , "Turno" => $value->Turno
                                , "Rol" => $value->Rol
                                , "Departamento" => $value->Departamento
                ];
            }
        }

        if (isset($array_data) && is_array($array_data) && count($array_data) > 0 ){
            foreach ($array_data as $key => $plantilla_general) {
                foreach ($v_rango_fechas as $key1 => $Fecha) {

                    $sql_ventas= "EXEC get_control_a_ceros_ventas '".$Fecha."', ".$plantilla_general['IdTrab'];
                    $sql_fechas= "EXEC get_control_a_ceros_faltas '".$Fecha."', ".$plantilla_general['IdTrab'];

                    $ventas = DB::connection('sqlsrv')->select($sql_ventas);
                    $fecha_0= DB::connection('sqlsrv')->select($sql_fechas);

                    $valor= isset($ventas[0]->Ventas) ? $ventas[0]->Ventas : (isset($fecha_0->idtrab) ? '' : 0);
                    $rango_fecha[$key1]= $valor;
                    $calculos[]= $valor;

                    if (isset($ventas[0]->Ventas)){
                        $arr['vc_evento']= 'SQL Revisando sql_ventas.... Perro' . date("H:i:s");
                        $arr['vc_info']  = $sql_ventas . "\n ". $sql_ventas;
                        $arr['_truncate_']= false;
                        $this->LibCore->setSkynet( $arr );
                    }
                    unset($valor);
                }

                $plantilla_general['ventas_sum']= array_sum($calculos);
                $plantilla_general['ventas_avg']= round(array_sum($calculos) / count($calculos), 2);
                $plantilla_general['dias_en_cero']= count(array_filter($calculos, function($a) { return ($a == 0); } ));

                $result[]= array_merge($plantilla_general, $rango_fecha);

                unset($rango_fecha);
                unset($calculos);
            }
        }

        $result= isset($result) ? json_encode($result) : '';

        $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
        $arr['vc_info']  = $result;
        $this->LibCore->setSkynet( $arr );


        return $result;
    }

    public function get_control_a_ceros_by_datatable_full(Request $request)
    {
        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : date('Y-m-d', strtotime('-1 days')) );

        if (is_null($fecha)){

            $v_rango_fechas= $this->getLastNDays(7, 'Y-m-d');

            foreach ($v_rango_fechas as $key => $value) {
                $fecha_inicial= $value; break;
            }

            foreach (array_reverse($v_rango_fechas) as $key => $value) {
                $fecha_final= $value; break;
            }

            return "No se encontro registros ".$fecha_inicial." del ".$fecha_final." Enviar fecha despues del 2022-10-12";

            $arr['vc_evento']= 'Fecha sin Personalizar ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $request->all(), JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        }else{
            $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $fecha, JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $v_rango_fechas= $this->f_rango_fechas( $fecha['dt_ini'], $fecha['dt_fin'] );
        }

        foreach ($v_rango_fechas as $key => $value) {
            $fecha_inicial= $value; break;
        }

        foreach (array_reverse($v_rango_fechas) as $key => $value) {
            $fecha_final= $value; break;
        }

        // if ($fecha_inicial >= "2022-10-12"){
        //     return "No se encontro registros ".$fecha_inicial." del ".$fecha_final." Enviar fecha despues del 2022-10-12";
        // }

        try {
            $sql= "EXEC get_control_a_ceros_full @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $sql_conn = DB::connection('sqlsrv');
            $plantilla_cero= $sql_conn->select($sql);

            $result = array_map(function ($value) {
                return (array)$value;
            }, $plantilla_cero);

        } catch (Exception $e) {

        }

        /*
        if ( is_array($plantilla_cero) && count($plantilla_cero) > 0 ) {
            foreach ($plantilla_cero as $key => $value) {
                $array_data[]= [  "IdTrab" => $value->IdTrab
                                , "Nombre_Completo" => $value->Gestor
                                , "Ingreso" => $value->Ingreso
                                , "Baja" => $value->Baja
                                , "Ant" => $value->Ant
                                , "Turno" => $value->Turno
                                , "Rol" => $value->Rol
                                , "Departamento" => $value->Departamento
                ];
            }
        }

        if (isset($array_data) && is_array($array_data) && count($array_data) > 0 ){
            foreach ($array_data as $key => $plantilla_general) {
                foreach ($v_rango_fechas as $key1 => $Fecha) {

                    $sql_ventas= "EXEC get_control_a_ceros_ventas '".$Fecha."', ".$plantilla_general['IdTrab'];
                    $sql_fechas= "EXEC get_control_a_ceros_faltas '".$Fecha."', ".$plantilla_general['IdTrab'];

                    $ventas = DB::connection('sqlsrv')->select($sql_ventas);
                    $fecha_0= DB::connection('sqlsrv')->select($sql_fechas);

                    $valor= isset($ventas[0]->Ventas) ? $ventas[0]->Ventas : (isset($fecha_0->idtrab) ? '' : 0);
                    $rango_fecha[$key1]= $valor;
                    $calculos[]= $valor;

                    if (isset($ventas[0]->Ventas)){
                        $arr['vc_evento']= 'SQL Revisando sql_ventas.... Perro' . date("H:i:s");
                        $arr['vc_info']  = $sql_ventas . "\n ". $sql_ventas;
                        $arr['_truncate_']= false;
                        $this->LibCore->setSkynet( $arr );
                    }
                    unset($valor);
                }

                $plantilla_general['ventas_sum']= array_sum($calculos);
                $plantilla_general['ventas_avg']= round(array_sum($calculos) / count($calculos), 2);
                $plantilla_general['dias_en_cero']= count(array_filter($calculos, function($a) { return ($a == 0); } ));

                $result[]= array_merge($plantilla_general, $rango_fecha);

                unset($rango_fecha);
                unset($calculos);
            }
        }
        */

        $result= isset($result) ? json_encode($result) : '';

        $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
        $arr['vc_info']  = $result;
        $arr['_truncate_']= false;
        $this->LibCore->setSkynet( $arr );


        return $result;
    }

    public function get_control_a_ceros_by_excel(Request $request)
    {
        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );

        if (is_null($request->rango_fecha)){

            $v_rango_fechas= $this->getLastNDays(7, 'Y-m-d');

            foreach ($v_rango_fechas as $key => $value) {
                $fecha_inicial= $value; break;
            }

            foreach (array_reverse($v_rango_fechas) as $key => $value) {
                $fecha_final= $value; break;
            }

            return "No se encontro registros ".$fecha_inicial." del ".$fecha_final." Enviar fecha despues del 2022-10-12 pruebas";

            $arr['vc_evento']= 'Fecha sin Personalizar ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $request->all(), JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        }else{
            $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $fecha, JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $v_rango_fechas= $this->f_rango_fechas( $fecha['dt_ini'], $fecha['dt_fin'] );
        }

        foreach ($v_rango_fechas as $key => $value) {
            $fecha_inicial= $value; break;
        }

        foreach (array_reverse($v_rango_fechas) as $key => $value) {
            $fecha_final= $value; break;
        }

        try {
            $sql= "EXEC get_control_a_ceros @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $plantilla_cero= DB::connection('sqlsrv')->select($sql);

            $arr['vc_evento']= 'Control a ceros Plantilla ' . date("H:i:s");
            $arr['vc_info']  = $sql ." \n Registros: ". count($plantilla_cero);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        } catch (Exception $e) {

        }

        if ( is_array($plantilla_cero) && count($plantilla_cero) > 0 ) {
            foreach ($plantilla_cero as $key => $value) {
                $array_data[]= [  "IdTrab" => $value->IdTrab
                                , "Nombre_Completo" => $value->Gestor
                                , "Ingreso" => $value->Ingreso
                                , "Baja" => $value->Baja
                                , "Ant" => $value->Ant
                                , "Turno" => $value->Turno
                                , "Rol" => $value->Rol
                                , "Departamento" => $value->Departamento
                ];
            }
        }

        if (isset($array_data) && is_array($array_data) && count($array_data) > 0 ){
            foreach ($array_data as $key => $plantilla_general) {
                foreach ($v_rango_fechas as $key1 => $Fecha) {

                    $sql_ventas= "EXEC get_control_a_ceros_ventas '".$Fecha."', ".$plantilla_general['IdTrab'];
                    $sql_fechas= "EXEC get_control_a_ceros_faltas '".$Fecha."', ".$plantilla_general['IdTrab'];

                    $ventas = DB::connection('sqlsrv')->select($sql_ventas);
                    $fecha_0= DB::connection('sqlsrv')->select($sql_fechas);

                    $valor= isset($ventas[0]->Ventas) ? $ventas[0]->Ventas : (isset($fecha_0->idtrab) ? '' : 0);
                    $rango_fecha[$key1]= $valor;
                    $calculos[]= $valor;

                    if (isset($ventas[0]->Ventas)){
                        $arr['vc_evento']= 'SQL Revisando sql_ventas.... Perro' . date("H:i:s");
                        $arr['vc_info']  = $sql_ventas . "\n ". $sql_ventas;
                        $arr['_truncate_']= false;
                        $this->LibCore->setSkynet( $arr );
                    }
                    unset($valor);

                }

                $plantilla_general['ventas_sum']= array_sum($calculos);
                $plantilla_general['ventas_avg']= round(array_sum($calculos) / count($calculos), 2);
                $plantilla_general['dias_en_cero']= count(array_filter($calculos, function($a) { return ($a == 0); } ));


                $result[]= array_merge($plantilla_general, $rango_fecha);

                unset($rango_fecha);
                unset($calculos);
            }
        }

        $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
        $arr['vc_info']  = $result;
        $arr['_truncate_']= false;
        $this->LibCore->setSkynet( $arr );



        date_default_timezone_set('America/Mexico_City');
        $nombre_archivo = date('yy-m-d_His').'_'.'_Reporte_Control_a_ceros.xlsx';

        //Limpiar buffer
        ob_end_clean();

        //Header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'"');
        #header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Control a ceros");

        $keys_names = array_keys($result[0]);

        $elems_arr = count($keys_names, COUNT_RECURSIVE);

        $ultima_columna = CoordinateCell::stringFromColumnIndex($elems_arr);

        $row_elems = array_keys($result);

        $count_rows = count($row_elems, COUNT_RECURSIVE);
        $rows_table = $count_rows + 1;

        $sheet->fromArray($keys_names, NULL, 'A1');
        $sheet->fromArray($result, NULL, 'A2');

        $table = new Table();
        $table->setName('TControlACeros');
        $table->setRange('A1:'.$ultima_columna.$rows_table);

        $tableStyle = new TableStyle();
        $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM4);

        $table->setStyle($tableStyle);

        $spreadsheet->getActiveSheet()->addTable($table);

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }

    public function get_control_a_ceros_by_excel_full(Request $request)
    {
        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );

        if (is_null($request->rango_fecha)){

            $v_rango_fechas= $this->getLastNDays(7, 'Y-m-d');

            foreach ($v_rango_fechas as $key => $value) {
                $fecha_inicial= $value; break;
            }

            foreach (array_reverse($v_rango_fechas) as $key => $value) {
                $fecha_final= $value; break;
            }

            return "No se encontro registros ".$fecha_inicial." del ".$fecha_final." Enviar fecha despues del 2022-10-12 pruebas";

            $arr['vc_evento']= 'Fecha sin Personalizar ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $request->all(), JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

        }else{
            $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $fecha, JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $v_rango_fechas= $this->f_rango_fechas( $fecha['dt_ini'], $fecha['dt_fin'] );
        }

        foreach ($v_rango_fechas as $key => $value) {
            $fecha_inicial= $value; break;
        }

        foreach (array_reverse($v_rango_fechas) as $key => $value) {
            $fecha_final= $value; break;
        }

        try {
            $sql= "EXEC get_control_a_ceros_full @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $sql_conn = DB::connection('sqlsrv');
            $plantilla_cero= $sql_conn->select($sql);

            $result = array_map(function ($value) {
                return (array)$value;
            }, $plantilla_cero);

        } catch (Exception $e) {

        }

        date_default_timezone_set('America/Mexico_City');
        $nombre_archivo = date('yy-m-d_His').'_'.'_Reporte_Control_a_ceros.xlsx';

        //Limpiar buffer
        ob_end_clean();

        //Header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'"');
        header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Control a ceros");

        $keys_names = array_keys($result[0]);

        $elems_arr = count($keys_names, COUNT_RECURSIVE);

        $ultima_columna = CoordinateCell::stringFromColumnIndex($elems_arr);

        $row_elems = array_keys($result);

        $count_rows = count($row_elems, COUNT_RECURSIVE);
        $rows_table = $count_rows + 1;

        $sheet->fromArray($keys_names, NULL, 'A1');
        $sheet->fromArray($result, NULL, 'A2');

        $table = new Table();
        $table->setName('TControlACeros');
        $table->setRange('A1:'.$ultima_columna.$rows_table);

        $tableStyle = new TableStyle();
        $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM4);

        $table->setStyle($tableStyle);

        $spreadsheet->getActiveSheet()->addTable($table);

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;


    }

    /*
    |--------------------------------------------------------------------------
    | Datatable USO DE SISTEMA especial como se requiere en js
    |--------------------------------------------------------------------------
    |
    | @return json
    |
    */
    public function get_uso_de_sistema_by_datatable(Request $request)
    {

        $fecha= $this->LibCore->date_format( isset($request->rango_fecha) ? $request->rango_fecha : '' );

        if (is_null($request->rango_fecha)){

            $arr['vc_evento']= 'Fecha sin Personalizar ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $request->all(), JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $dt_ini= "2022-09-01";
            $dt_fin= "2022-09-31";

            $v_rango_fechas= $this->getLastNDays(7, 'Y-m-d');

        }else{
            $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
            $arr['vc_info']  = json_encode( $fecha, JSON_PRETTY_PRINT);
            $arr['_truncate_']= false;
            $this->LibCore->setSkynet( $arr );

            $dt_ini= "2022-09-01";
            $dt_fin= "2022-09-31";

            $v_rango_fechas= $this->f_rango_fechas( $fecha['dt_ini'], $fecha['dt_fin'] );
        }

        $data= Reportventas3::select("user_id"
                                    , "Nombre_Completo"
                                    , "Ingreso"
                                    , "Baja"
                                    , "Ant"
                                    , "Turno"
                                    , "Rol"
                                    , "Departamento"
                                    , "Puesto"
        )->whereBetween('fecha', [$dt_ini, $dt_fin])
        ->groupBy("user_id")->take(10)->orderby("Nombre_Completo")->get();

        $total  = $data->count();

        if ($total){
            foreach ($data as $key => $value) {
                $array_data[]= [ "user_id" => $value->user_id
                        , "Nombre_Completo" => $value->Nombre_Completo
                        , "Ingreso" => $value->Ingreso
                        , "Baja" => $value->Baja
                        , "Ant" => $value->Ant
                        , "Turno" => $value->Turno
                        , "Rol" => $value->Rol
                        , "Puesto" => $value->Puesto
                        , "Departamento" => $value->Departamento
                ];
            }
        }

        if (isset($array_data) && is_array($array_data) && count($array_data) > 0 ){
            foreach ($array_data as $key => $value) {
                foreach ($v_rango_fechas as $key1 => $value1) {
                    $data= Reportventas2::select("ventas")->where("fecha", $value1)->where( "user_id", $value['user_id'])->get()->toArray();
                    $fecha_0= Reportventas5::select("User_Id")->where("Fecha", $value1)->where( "User_Id", $value['user_id'])->get()->toArray();
                    $valor= isset($data[0]['ventas']) ? $data[0]['ventas'] : (isset($fecha_0[0]['User_Id']) ? '' : 0);
                    $aa[$key1]= $valor;
                    $calculos[]= $valor;
                }

                $value['ventas_avg']= round(array_sum($calculos) / count($calculos), 2);

                $var1[]= array_merge($value, $aa);

                unset($aa);
                unset($calculos);
            }
        }

        $result= isset($var1) ? json_encode($var1) : '';

        return $result;

    }


    /*
    |--------------------------------------------------------------------------
    | Generar Excel y descargarlo
    |--------------------------------------------------------------------------
    | @return json
    |
    */
    public function exportarControlACerosExcel(Request $request)
    {
        $data= Reportventas3::select("user_id"
                                    , "Nombre_Completo"
                                    , "Ingreso"
                                    , "Baja"
                                    , "Ant"
                                    , "Turno"
                                    , "Rol"
                                    , "Departamento"
        )->groupBy("user_id")->limit(4)->get();

        $total  = $data->count();

        foreach ($data as $key => $value) {
            $arr[]= array(   $value->user_id
                            , $value->Nombre_Completo
                            , $value->Ingreso
                            , $value->Baja
                            , $value->Ant
                            , $value->Turno
                            , $value->Rol
                            , $value->Descripcion
                            , $value->Departamento
                            , $value->Uso
                            , $value->Avg
                            , $value->user_id
            );


            $date=date_create($value->Ingreso);

            $faltas[]= array( $value->user_id
                            , $value->Nombre_Completo
                            , $value->Ingreso
            );
        }


        $this->crear_archivos_faltas($faltas);
        $this->crear_archivos($arr);

        $id_user= Auth::id()!== null ? Auth::id() :  '';

        $nombre_archivo= 'Reporte_Control_Cero.xlsx';
        // $nombre_archivo= "Reporte_Control_Cero_".$id_user."_".date("Y-m-d h:i:s").'.xlsx';
        $this->LibCore->setSkynet( ['vc_evento'=> 'exportarControlACerosExcel' , 'vc_info' => $nombre_archivo ] );
        $process = new Process( [ 'python3', public_path("/")."ControlACeros.py" , $nombre_archivo ] );
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = $process->getOutput();

        return $nombre_archivo;

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

    public function crear_archivos_faltas($arr)
    {
        // Archivo donde se guardan los datos para formar el Excel
        if (Storage::exists('public/json_data_faltas.json')){
            Storage::disk('public')->put('json_data_faltas.json', json_encode($arr));
        }else{
            Storage::disk('public')->put('json_data_faltas.json', json_encode($arr));
        }
    }

    public function f_rango_fechas( $dt_ini, $dt_fin)
    {
        $begin = new \DateTime( $dt_ini );
        $end   = new \DateTime( $dt_fin );

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $fecha= $i->format("Y-m-d");
            $begin = new \DateTime( $fecha );
            $formato_fecha = date_format($begin,"d M Y");
            $arr[$formato_fecha]= $fecha;
        }

        return $arr;
    }


    public function getLastNDays($days, $format = 'd/m'){
        $m = date("m"); $de= date("d"); $y= date("y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            $fecha= date($format, mktime(0,0,0,$m,($de-$i),$y));
            $begin = new \DateTime( $fecha );
            $formato_fecha = date_format($begin,"d M Y");
            $dateArray[$formato_fecha] = $fecha;
        }
        return array_reverse($dateArray);
    }

}
