<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Migraciones;
use App\Lib\LibCore;

class MigracionesController extends Controller
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
    | Todo es controlado por JS migraciones.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('migraciones')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla migraciones"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_migraciones' , 'vc_info' => "index - migraciones" ] );

        return view('migraciones');
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_migraciones_by_id(Request $request)
    {
        $data= Migraciones::select('migration'
                                    , 'batch'
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
    public function get_migraciones_by_datatable()
    {
        if(!\Schema::hasTable('migrations')){
            return json_encode(array("data"=>"" ));
        }

        $data= Migraciones::select(   "id"
                                    , "migration"
                                    , "batch"
        )->orderby("id", "desc")->get();

        foreach ($data as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->migration
                            , $value->batch
                            , $value->id
            );
        }

        $json_data = array(
            "draw"            => intval( 10 ),   
            "recordsTotal"    => intval( 1 ),  
            "recordsFiltered" => intval( 33 ),
            "data"            => isset($arr) && is_array($arr)? $arr : ''
        );

        if(1 > 0){
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
    public function delete_migraciones(Request $request)
    {
        $id=$request->id;
        Migraciones::where('id', $id)->delete();
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
    public function undo_delete_migraciones(Request $request)
    {

    }


    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_migraciones()
    {
        Skynet::truncate();
    }
}
