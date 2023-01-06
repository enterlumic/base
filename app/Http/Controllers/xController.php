<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\TD_Articulos;
use App\Models\Users_menu;
use App\Models\ProductosSAT;
use App\Models\ClientesAdjuntos;
use App\Models\Clientes_comentarios;
use App\Models\Desepenio;
use App\Models\Jefepisos;
use App\Models\Empleado;
use App\Models\Reporteproductividad;
use App\Models\Reportventas3;
use App\Models\Reportventas2;
use App\Models\Reportventas1;
use App\Lib\FileUploader;
use App\Lib\LibCore;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SkynetController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class xController extends Controller
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
    | Todo es controlado por JS clientes.js
    |
    */
    public function index()
    {

            // $r= shell_exec("/var/www/html/gus/sh/git_status.sh");
            // print_r($r);


                $r= shell_exec("cd /var/www/html/gus && find -iname '*console_gt*' ");
                print_r($r);
                return;

//             [phone_number] => 8672124262
//             [entry_date] => 20221130
//             [called_count] => 0
//             [len] => 10
//             [serie] => 867212
//             [city] => NUEVO LAREDO
//             [state] => TAMPS
//             [status] => NORMAL
//             [carrier] => IUSACEL
//             [type_db] => MUEVETE
//             [file_name] => R4MVT TECSA DIC.xlsb



        $fecha= "20221219";
        $fecha2= "20221220";
        $sql= "EXEC get_desempenio @FechaInicial='".$fecha."', @FechaFinal='".$fecha2."'";
        // return;
        $consultal_srv= DB::connection('sqlsrv')->select($sql);


        dd($consultal_srv);
        foreach ($consultal_srv as $key => $value) {
            // dd($value->IdTrab);

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

        // $query= DB::connection('sqlsrv')->select(
        //     "SELECT * FROM OPENQUERY 
        //     ( VICI2 ,
        //         'SELECT * FROM asterisk.vicidial_carrier_log limit 10'
        //     )"
        // );
        // dd($query);

    }

    public function excel()
    {
        $path= public_path("/")."storage/test.xlsx";

        if (file_exists($path))
        {

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load( $path );
            $d=$spreadsheet->getSheet(0)->toArray();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // $i=1;
            unset($sheetData[0]);

            echo "<pre>";
            print_r($sheetData);


        }else{
            dd(00);
        }        
    }

    public function sql(){
        $sql= "SELECT TOP 1 * FROM DWH.[Logs].[dbo].TrabajadorSonarh ";
        $result= DB::connection('sqlsrv')->select($sql);

        dd($result);

        foreach ($result as $key => $value) {
            $data_insert[]=[ 'Nombre' => $value->Nombre,
                    'Paterno' => $value->Paterno,
                    'Materno' => $value->Materno,
                    'FechaIngreso' => $value->FechaIngreso,
                    'FechaBaja' => $value->FechaBaja,
                    'Fecha' => $value->Fecha,
                    'De' => $value->De,
                    'Nacimiento' => $value->Nacimiento,
                    'Centro' => $value->Centro,
                    'Costo' => $value->Costo,
                    'Departamento' => $value->Departamento,
                    'Puesto' => $value->Puesto,
                    'Active' => $value->Active,
                    'DateCreated' => $value->DateCreated,
                    'DateModified' => $value->DateModified
            ];                
        }
    }

    public function asterisk(){
        // $sql= "SELECT * FROM OPENQUERY ( "VICI2" ,'SELECT * FROM asterisk.vicidial_carrier_log limit 10' )");
        // $plantilla_cero= DB::connection('sqlsrv')->select($sql);
        // dd($plantilla_cero);
        //     $q= DB::select(DB::raw('SELECT * FROM asterisk.vicidial_carrier_log limit 10'));
        //     dd($q);

        // SELECT * FROM openquery(VICIDIAL5,'CALL `asterisk`.`AgentTimeByHour`(''2022-12-22'', ''2022-12-22'');')

        // SELECT * FROM openquery(VICIDIAL5,'SHOW CREATE PROCEDURE asterisk.AgentTimeByHour')

    }

    public function uno(){




        $query= DB::connection('sqlsrv')->select(
            "SELECT * FROM OPENQUERY 
            ( DWH ,
                'SELECT TOP 1 * FROM [DBA].[dbo].[1-BASEACTUAL]'
            )"
        );



        // echo "<pre>";
        // print_r($query);
        // return;

        foreach ($query as $key => $value) {
            echo $value->phone_number;
        }

        return;
    }



}
