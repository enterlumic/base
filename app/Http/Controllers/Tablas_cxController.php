<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Tablas_cx;
use App\Lib\LibCore;

class Tablas_cxController extends Controller
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
    | Todo es controlado por JS tablas_cx.js
    |
    */
    public function index()
    {

        if(!\Schema::hasTable('tablas_cx')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla tablas_cx"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_tablas_cx' , 'vc_info' => "index - tablas_cx" ] );

        return view('tablas_cx');
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_tablas_cx_by_id(Request $request)
    {
        $data= Tablas_cx::select('vc_table')->where('id', $request->id)->get();
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
    public function get_tablas_cx_by_datatable()
    {

        $data = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'crm';");

        foreach ($data as $key => $value) {
            $arr[]= array(0,$value->table_name, 0);
        }
        $total= 1000;
        
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
    public function delete_tablas_cx(Request $request)
    {
        $data = DB::select("drop table ".$request->nombre_tabla.";");
    }

}
