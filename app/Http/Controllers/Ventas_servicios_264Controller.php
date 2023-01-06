<?php

namespace App\Http\Controllers;

##require dirname(__FILE__,4).'\\vendor\\autoload.php';
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

class Ventas_servicios_264Controller extends Controller
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
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_ventas_servicios_264' , 'vc_info' => "index - ventas_servicios_264" ] );
        return view('ventas_servicios_264');
    }

    public function get_ventas_servicios_264_by_datatable(Request $request) {
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

        try {
            $sql= "EXEC Csp_Reporte_Ventas_Servicios @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $sql_conn = DB::connection('sqlsrv');
            $plantilla_cero= $sql_conn->select($sql);

            $result = array_map(function ($value) {
                return (array)$value;
            }, $plantilla_cero);

        } catch (Exception $e) {

        }

        ##return $plantilla_cero;

        $result= isset($result) ? json_encode($result) : '';

        $arr['vc_evento']= 'Fecha Personalizado ' . date("H:i:s");
        $arr['vc_info']  = $result;
        $arr['_truncate_']= false;
        $this->LibCore->setSkynet( $arr );


        return $result;
    }

    public function get_ventas_servicios_264_by_excel(Request $request)
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
            $sql= "EXEC Csp_Reporte_Ventas_Servicios @FechaInicial='".$fecha_inicial."', @FechaFinal='".$fecha_final."'";
            $sql_conn = DB::connection('sqlsrv');
            $plantilla_cero= $sql_conn->select($sql);

            $result = array_map(function ($value) {
                return (array)$value;
            }, $plantilla_cero);

        } catch (Exception $e) {

        }

        date_default_timezone_set('America/Mexico_City');
        $nombre_archivo = date('yy-m-d_His').'_'.'Ventas_servicios_264_R3.xlsx';

        //Header
        if ((!isset($request->cron))) {
            //Limpiar buffer
            ob_end_clean();

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$nombre_archivo.'"');
            header('Cache-Control: max-age=0');
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Ventas (servicios) 264 R3");

        $keys_names = array_keys($result[0]);

        $elems_arr = count($keys_names, COUNT_RECURSIVE);

        $ultima_columna = CoordinateCell::stringFromColumnIndex($elems_arr);

        $row_elems = array_keys($result);

        $count_rows = count($row_elems, COUNT_RECURSIVE);
        $rows_table = $count_rows + 1;

        $sheet->fromArray($keys_names, NULL, 'A1');
        $sheet->fromArray($result, NULL, 'A2');

        $table = new Table();
        $table->setName('TVentasServicios264R3');
        $table->setRange('A1:'.$ultima_columna.$rows_table);

        $tableStyle = new TableStyle();
        $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM4);

        $table->setStyle($tableStyle);

        $spreadsheet->getActiveSheet()->addTable($table);

        if ((!isset($request->cron))) {

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            exit;
        }
        else if (isset($request->cron)) {
            $dir_save = "public/Reportes264/";
            $writer = new Xlsx($spreadsheet);

            $writer->save($dir_save.$nombre_archivo);

            return "Reportes264/".$nombre_archivo;
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
