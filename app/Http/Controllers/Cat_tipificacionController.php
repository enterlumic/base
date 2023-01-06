<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Cat_tipificacion;
use App\Lib\LibCore;

class Cat_tipificacionController extends Controller
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
    | Todo es controlado por JS cat_tipificacion.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('cat_tipificacion')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla cat_tipificacion"));
        }

        return view('cat_tipificacion');
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
    public function set_cat_tipificacion(Request $request)
    {
        if(!\Schema::hasTable('cat_tipificacion')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $data=[ 'vc_tipificacion' => $request->vc_tipificacion,
                'vc_descripcion' => $request->vc_descripcion,
        ];

        sleep(1);
        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $cat_tipificacion = Cat_tipificacion::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $cat_tipificacion = Cat_tipificacion::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_cat_tipificacion(Request $request)
    {
        if(!\Schema::hasTable('cat_tipificacion')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['vc_tipificacion'=> trim($line) ] ;

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
    public function get_cat_tipificacion_by_id(Request $request)
    {
        $data= Cat_tipificacion::select('vc_tipificacion'
                                    , 'vc_descripcion'
        )->where('id', $request->id)->get();
        sleep(1);
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cat_tipificacion_all(Request $request)
    {
        $data= Cat_tipificacion::select('id'
                                    , 'vc_tipificacion AS vc_nombre'
                                    , 'vc_descripcion'
        )->get();
        sleep(1);
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cat_tipificacion_by_datatable()
    {
        if(!\Schema::hasTable('cat_tipificacion')){
            return json_encode(array("data"=>"" ));
        }

        $data= Cat_tipificacion::select("id"
                                    , "vc_tipificacion"
                                    , "vc_descripcion"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_tipificacion
                            , $value->vc_descripcion
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
    public function delete_cat_tipificacion(Request $request)
    {
        $id=$request->id;
        Cat_tipificacion::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_cat_tipificacion(Request $request)
    {
        $id=$request->id;
        Cat_tipificacion::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }
}
