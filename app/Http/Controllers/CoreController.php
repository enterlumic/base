<?php

namespace App\Http\Controllers;
use Throwable;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Lib\LibCore;
use App\Http\Controllers\SkynetController;
use App\Http\Controllers\Cortes_por_horaController;

class CoreController extends Controller
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
        
    }

    public function python()
    {
        $python= shell_exec('python3 -VV');
        return $python;
    }

    public function coreExportarExcel(Request $request)
    {
        if ( $request->TipoReporte == "desepenio" ){
            $result = app('App\Http\Controllers\DesepenioController')->generarReporteExcelDesempenio($request);
            return $result;
        }

        if ( $request->TipoReporte == "cortes_por_hora" ){
            $result = app('App\Http\Controllers\Cortes_por_horaController')->get_cortes_por_hora_by_datatable($request);
            return $result;
        }

        if ( $request->TipoReporte == "metricas_conexiones" ){
            $result = app('App\Http\Controllers\Metricas_conexionesController')->generarReporteExcel();
            return $result;
        }

        if ( $request->TipoReporte == "agentes_por_hora" ){
            $request->merge(['cron' => true]);
            $result = app('App\Http\Controllers\Agentes_por_horaController')->get_agentes_por_hora_by_datatable($request);
            return $result;
        }

    }

}
