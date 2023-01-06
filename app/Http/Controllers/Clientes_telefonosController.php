<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Clientes_telefonos;
use App\Lib\LibCore;

class Clientes_telefonosController extends Controller
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
    | Todo es controlado por JS clientes_telefonos.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('clientes_telefonos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla clientes_telefonos"));
        }

        return view('clientes_telefonos');
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
    public function set_clientes_telefonos(Request $request)
    {

        if(!\Schema::hasTable('clientes_telefonos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Clientes_telefonos"));
        }

        if( empty($request->vc_telefono) ){
            return json_encode(array("b_status"=> false, "vc_message" => "requerido: vc_telefono"));
        }

        $data=[ 'id_cliente' => $request->id_cliente,
                'vc_telefono' => $request->vc_telefono,
                'vc_alias' => $request->vc_alias,
        ];

        $count= Clientes_telefonos::where( ['vc_telefono' => $request->vc_telefono])->get()->count();

        // Si ya existe solo se actualiza el registro
        if ( isset($request->id) || $count > 0 ){
            $clientes_telefonos = Clientes_telefonos::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $clientes_telefonos = Clientes_telefonos::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_clientes_telefonos(Request $request)
    {
        if(!\Schema::hasTable('clientes_telefonos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['id_cliente'=> trim($line)] ;

        }

        sleep(1);

        Cat_tipificacion::truncate();
        Cat_tipificacion::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_clientes_telefonos_by_id(Request $request)
    {
        $data= Clientes_telefonos::select('id_cliente'
                                    , 'vc_telefono'
                                    , 'vc_alias'
        )->where('id', $request->id)->get();
        sleep(1);
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por vc_telefono
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_clientes_telefonos_by_telefono($vc_telefono)
    {
        $data= Clientes_telefonos::select('id_cliente', 'vc_telefono' , 'vc_alias')->where('vc_telefono', $vc_telefono)->get();

        if ($data->count() > 0){
            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "data" =>  ['vc_message'=> 'Sin resultados'] ));
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
    public function get_clientes_telefonos_by_datatable()
    {
        if(!\Schema::hasTable('clientes_telefonos')){
            return json_encode(array("data"=>"" ));
        }

        $data= Clientes_telefonos::select("id"
                                    , "id_cliente"
                                    , "vc_telefono"
                                    , "vc_alias"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_telefono
                            , $value->vc_alias
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

    /*
    |--------------------------------------------------------------------------
    | Eliminar registro por id
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function delete_clientes_telefonos(Request $request)
    {
        $id=$request->id;
        Clientes_telefonos::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_clientes_telefonos(Request $request)
    {
        $id=$request->id;
        Clientes_telefonos::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }


    /*
    |--------------------------------------------------------------------------
    | Truncar toda la tabla util para hacer pruebas
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function truncate_clientes_telefonos()
    {
        Skynet::truncate();
    }
}
