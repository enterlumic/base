<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Servidorteiker;
use App\Lib\LibCore;

class ServidorteikerController extends Controller
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
    | Todo es controlado por JS servidorteiker.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('servidorteiker')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla servidorteiker"));
        }

        return view('servidorteiker');
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
    public function set_servidorteiker(Request $request)
    {
        if(!\Schema::hasTable('servidorteiker')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Servidorteiker"));
        }

        $data=[ 'vc_url_api_teiker' => $request->vc_url_api_teiker,
                'vc_db_host_teiker' => $request->vc_db_host_teiker,
                'vc_db_port_teiker' => $request->vc_db_port_teiker,
                'vc_db_database_teiker' => $request->vc_db_database_teiker,
                'vc_db_username_teiker' => $request->vc_db_username_teiker,
                'vc_db_password_teiker' => $request->vc_db_password_teiker,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $servidorteiker = Servidorteiker::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $servidorteiker = Servidorteiker::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
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
    public function get_servidorteiker_by_id(Request $request)
    {
        $data= Servidorteiker::select('vc_url_api_teiker'
                                    , 'vc_db_host_teiker'
                                    , 'vc_db_port_teiker'
                                    , 'vc_db_database_teiker'
                                    , 'vc_db_username_teiker'
                                    , 'vc_db_password_teiker'
        )->where('id', $request->id)->get();

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
    public function get_servidorteiker_by_datatable()
    {
        if(!\Schema::hasTable('servidorteiker')){
            return json_encode(array("data"=>"" ));
        }

        $data= Servidorteiker::select("id"
                                    , "vc_url_api_teiker"
                                    , "vc_db_host_teiker"
                                    , "vc_db_port_teiker"
                                    , "vc_db_database_teiker"
                                    , "vc_db_username_teiker"
                                    , "vc_db_password_teiker"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_url_api_teiker
                            , $value->vc_db_host_teiker
                            , $value->vc_db_port_teiker
                            , $value->vc_db_database_teiker
                            , $value->vc_db_username_teiker
                            , $value->vc_db_password_teiker
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

}
