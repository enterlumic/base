<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Cat_red_social;
use App\Lib\LibCore;

class Cat_red_socialController extends Controller
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
    | Todo es controlado por JS cat_red_social.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('cat_red_social')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla cat_red_social"));
        }

        return view('cat_red_social');
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
    public function set_cat_red_social(Request $request)
    {
        if(!\Schema::hasTable('cat_red_social')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_red_social"));
        }

        $data=[ 'vc_red_social' => $request->vc_red_social,
                'vc_url' => $request->vc_url,
                'vc_icono' => $request->vc_icono,
        ];

        sleep(1);
        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $cat_red_social = Cat_red_social::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $cat_red_social = Cat_red_social::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_cat_red_social(Request $request)
    {
        if(!\Schema::hasTable('cat_red_social')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
            $line = $arr[$i];
            $data[]=  ['vc_red_social'=> trim($line)] ;
        }

        sleep(1);

        Cat_red_social::truncate();
        Cat_red_social::insert($data);

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
    public function get_cat_red_social_by_id(Request $request)
    {
        $data= Cat_red_social::select('vc_red_social'
                                    , 'vc_url'
                                    , 'vc_icono'
        )->where('id', $request->id)->get();
        sleep(1);
        return json_encode(array("b_status"=> true, "data" => $data));
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener todos los registros para fines de mostrar en un combo
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_cat_red_social_all(Request $request)
    {
        $data= Cat_red_social::select('id', 'vc_red_social as vc_nombre', 'vc_url', 'vc_icono')->get();
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
    public function get_cat_red_social_by_datatable()
    {
        if(!\Schema::hasTable('cat_red_social')){
            return json_encode(array("data"=>"" ));
        }

        $data= Cat_red_social::select("id"
                                    , "vc_red_social"
                                    , "vc_url"
                                    , "vc_icono"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_red_social
                            , $value->vc_url
                            , $value->vc_icono
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
    public function delete_cat_red_social(Request $request)
    {
        $id=$request->id;
        Cat_red_social::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_cat_red_social(Request $request)
    {
        $id=$request->id;
        Cat_red_social::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }
}
