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
use App\Lib\LibCore;

class CronController extends Controller
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
    | Todo es controlado por JS ejecutar_cron.js
    |
    */
    public function closeLog()
    {
        $sql= "EXEC get_closer_log";
        $data= DB::connection('sqlsrv')->select($sql);

        foreach ($data as $key => $value) {
            $arr_data[]= array(   $value->ServidorOrigen
                                , $value->closecallid
                                , $value->lead_id
                                , $value->list_id
                                , $value->campaign_id
                                , $value->call_date
                                , $value->start_epoch
                                , $value->end_epoch
                                , $value->lenght_in_sec
                                , $value->status
                                , $value->phone_number
                                , $value->user
                                , $value->user_group
            );
        }

        $vicidial_log= $this->vicidial_log();

        if (!isset($arr_data)){
            return false;
        }

        $title[]= array("ServidorOrigen", "closecallid", "lead_id", "list_id", "campaign_id", "call_date", "start_epoch", "end_epoch", "lenght_in_sec", "status", "phone_number", "user", "user_group");

        $arr_data= array_merge($title, $arr_data);

        $nombre_archivo= 'Reporte_vicidial.xlsx';


        $this->LibCore->crear_archivos($arr_data);
        $process = new Process( [ 'python3', public_path("/")."reporte_vicidial_closer_log.py" , $nombre_archivo  ] );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = $process->getOutput();        

        return $nombre_archivo;
    }

    public function vicidial_log(){
        $sql= "EXEC get_vicidial_log";
        $data= DB::connection('sqlsrv')->select($sql);

        foreach ($data as $key => $value) {
            $arr_data[]= array( $value->Id,
                                $value->ServidorOrigen,
                                $value->uniqueid,
                                $value->lead_id,
                                $value->list_id,
                                $value->campaign_id,
                                $value->call_date,
                                $value->start_epoch,
                                $value->end_epoch,
                                $value->length_in_sec,
                                $value->status,
                                $value->phone_code,
                                $value->phone_number,
                                $value->user,
                                $value->comments,
                                $value->processed,
                                $value->user_group,
                                $value->term_reason,
                                $value->alt_dial,
                                $value->called_count,
            );
        }

        if (!isset($arr_data)){
            return false;
        }

        $title[]= array("Id", "ServidorOrigen", "uniqueid", "lead_id", "list_id", "campaign_id", "call_date", "start_epoch", "end_epoch", "length_in_sec", "status", "phone_code", "phone_number", "user", "comments", "processed", "user_group", "term_reason", "alt_dial", "called_count");

        $arr_data= array_merge($title, $arr_data);
        $this->LibCore->crear_archivos_hoja2($arr_data);
    }

}

