<?php
namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Skynet;
use App\Models\User;
use App\Models\CuentaMovimientos;
use App\Models\ClienteUbicacionesDestino;
use App\Models\Envio;
use App\Models\TipoEnvio;
use App\Lib\LibCore;
use App\Http\Controllers\SkynetController;
class Dashboard extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;


    public function __construct(){
        // Variables que se ocupa en cualquier parte para esta clase
        $this->LibCore = new LibCore();
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_Dashboard' , 'vc_info' => "index - Dashboard" ] );
        return view('dashboard');
    }

    public function cron_reporte(){
        $data= Skynet::select("id", "vc_evento", "vc_info", "created_at")
        ->where('vc_evento', 'init_cron')
        ->orderBy('id', 'desc')
        ->get()
        ->toArray();

        return json_encode($data);
    }

    public function _login(){

        $fecha= $this->LibCore->getLastNDays(7, 'Y-m-d');
        $this->LibCore->if_exists_sp('get_total_login', true);        
        $sql= "CALL get_total_login( '".current($fecha)."', '".end($fecha)."' )";
        $data = DB::select($sql);

        return json_encode($data);
    }
}