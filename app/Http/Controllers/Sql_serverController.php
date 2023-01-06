<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Sql_server;
use App\Models\Sonar;
use App\Lib\LibCore;
use App\Http\Controllers\DateTime;
use App\Models\Carrier_status;

class Sql_serverController extends Controller
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
    | Todo es controlado por JS sql_server.js
    |
    */
    public function index()
    {


        $query= $this->data_arr();
        foreach ($query as $key => $value) {
            Carrier_status::create( $value );
        }

        // $this->LibCore->if_exists_sp('get_campana', true);
        // $sql= "CALL get_campana(0, '".$id_request."' )";
        // $data = DB::select( $sql );

        // $this->LibCore->setSkynet( ['vc_evento'=> 'index_carrier_status' , 'vc_info' => "index - carrier_status" ] );

    }

    public function info()
    {
      phpinfo();
    }


    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function sp()
    {
        echo "<pre>";

        // Listar SPS
        $sql= " SELECT ROUTINE_SCHEMA, ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES  ";
        $plantilla_cero= DB::connection('sqlsrv')->select($sql);

        echo "<h2> Store Procedure CrmMis </h2> <br>";
        foreach ($plantilla_cero as $key => $value) {
            echo $value->ROUTINE_NAME . "<br>";
        }

        echo "<h2> Store Procedure  </h2> <br>";
        // # Mostrar SP
        $sql= " sp_helptext get_control_a_ceros ";
        $plantilla_cero= DB::connection('sqlsrv')->select($sql);
        // print_r($plantilla_cero); return;
        // dd($plantilla_cero);
        foreach ($plantilla_cero as $key => $value) {
            print_r($value->Text);
        }

        echo "<h2> Store Procedure Logs </h2> <br>";

        $query= DB::connection('sqlsrv')->select(
            "SELECT * FROM OPENQUERY 
            ( DWH ,
                'SELECT ROUTINE_SCHEMA, ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES'
            )"
        );

        foreach ($query as $key => $value) {
            echo $value->ROUTINE_NAME . "<br>";
        }

        return;
    }

    public function data_arr(){
        return  array (
          0 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-31',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '39961',
          ),
          1 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-04',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '27164',
          ),
          2 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-13',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '7659',
          ),
          3 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-22',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6773',
          ),
          4 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-20',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6537',
          ),
          5 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-12',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6696',
          ),
          6 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-21',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '632',
          ),
          7 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-30',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '12586',
          ),
          8 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-17',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '9019',
          ),
          9 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-05',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '715',
          ),
          10 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-24',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '28575',
          ),
          11 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-30',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1030',
          ),
          12 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-18',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '385',
          ),
          13 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-11',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '2640',
          ),
          14 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-07',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '3856',
          ),
          15 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-02',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '83',
          ),
          16 => 
          array (
            'servidor' => 'VICIDIAL2',
            'call_date' => '2022-02-09',
            'vc_campana' => 'MVTPPRE',
            'dialstatus' => 'Calls',
            'calls' => '1527',
          ),
          17 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-17',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '17049',
          ),
          18 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-30',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '104',
          ),
          19 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-17',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '3841',
          ),
          20 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-05',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '306',
          ),
          21 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-20',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '577',
          ),
          22 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-12',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '12',
          ),
          23 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-26',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '4989',
          ),
          24 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-27',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '37788',
          ),
          25 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-26',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '5475',
          ),
          26 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-29',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '39092',
          ),
          27 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-10',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5417',
          ),
          28 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-14',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '247',
          ),
          29 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-25',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '3504',
          ),
          30 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-09',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '139',
          ),
          31 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-13',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '18523',
          ),
          32 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-13',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1822',
          ),
          33 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-11',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5342',
          ),
          34 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-24',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '470',
          ),
          35 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-02',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '43301',
          ),
          36 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-29',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '4865',
          ),
          37 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-14',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '34022',
          ),
          38 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-28',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '1648',
          ),
          39 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-09',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '224',
          ),
          40 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-22',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1413',
          ),
          41 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-14',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1185',
          ),
          42 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-03',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '22000',
          ),
          43 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-22',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '26651',
          ),
          44 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-21',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6720',
          ),
          45 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-31',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1954',
          ),
          46 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-19',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1577',
          ),
          47 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-07',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '912',
          ),
          48 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-10',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '13',
          ),
          49 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-20',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1345',
          ),
          50 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-26',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '155',
          ),
          51 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-29',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '2547',
          ),
          52 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-14',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '7048',
          ),
          53 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-28',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '26',
          ),
          54 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-13',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '16584',
          ),
          55 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-05',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '36053',
          ),
          56 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-09',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6399',
          ),
          57 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-26',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '38576',
          ),
          58 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-03',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '7663',
          ),
          59 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-21',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '192',
          ),
          60 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-24',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5962',
          ),
          61 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-10',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '31994',
          ),
          62 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-03',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1722',
          ),
          63 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-15',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1872',
          ),
          64 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-01',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '1152',
          ),
          65 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-04',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5748',
          ),
          66 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-31',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '885',
          ),
          67 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-25',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '6288',
          ),
          68 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-24',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '2731',
          ),
          69 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-01',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '8014',
          ),
          70 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-19',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '33598',
          ),
          71 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-09',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '48003',
          ),
          72 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-21',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '32621',
          ),
          73 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-30',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '780',
          ),
          74 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-15',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '1078',
          ),
          75 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-25',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '475',
          ),
          76 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-15',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '26429',
          ),
          77 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-01',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '16260',
          ),
          78 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-12',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '2321',
          ),
          79 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-10',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '2846',
          ),
          80 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-11',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '32074',
          ),
          81 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-12',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '29960',
          ),
          82 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-27',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '1207',
          ),
          83 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-27',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '8139',
          ),
          84 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-04',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '9836',
          ),
          85 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-04',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '42212',
          ),
          86 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-17',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5696',
          ),
          87 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-19',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '8926',
          ),
          88 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-15',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '6116',
          ),
          89 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-20',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '30269',
          ),
          90 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-19',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '50',
          ),
          91 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-18',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '8512',
          ),
          92 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-02',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '4872',
          ),
          93 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-29',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '130',
          ),
          94 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-03',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '13090',
          ),
          95 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-27',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '148',
          ),
          96 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-08',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '409',
          ),
          97 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-08',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '48305',
          ),
          98 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-01-31',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '7023',
          ),
          99 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-28',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '7275',
          ),
          100 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-25',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '36997',
          ),
          101 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-07',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '39367',
          ),
          102 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-01',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '24871',
          ),
          103 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-08',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '8982',
          ),
          104 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-05',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5827',
          ),
          105 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-22',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '159',
          ),
          106 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-18',
            'vc_campana' => 'ESTPREDI',
            'dialstatus' => 'Calls',
            'calls' => '653',
          ),
          107 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-18',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '31915',
          ),
          108 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-01-28',
            'vc_campana' => 'EXDATAUT',
            'dialstatus' => 'Calls',
            'calls' => '37823',
          ),
          109 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-08',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '130',
          ),
          110 => 
          array (
            'servidor' => 'VICIDIAL4',
            'call_date' => '2022-02-02',
            'vc_campana' => 'MVTPOS',
            'dialstatus' => 'Calls',
            'calls' => '5415',
          ),
          111 => 
          array (
            'servidor' => 'VICIDIAL3',
            'call_date' => '2022-02-07',
            'vc_campana' => 'EXCVOZPR',
            'dialstatus' => 'Calls',
            'calls' => '428',
          ),
        );        
    }

}
