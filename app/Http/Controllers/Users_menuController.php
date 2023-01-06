<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users_menu;
use App\Lib\LibCore;

class Users_menuController extends Controller
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
    | Todo es controlado por JS users_menu.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('users_menu')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla users_menu"));
        }

        return view('users_menu');
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
    public function set_users_menu(Request $request)
    {
        if(!\Schema::hasTable('users_menu')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Users_menu"));
        }

        $data=[ 'id_user' => intval($request->id) ];
        $id= $request->id;

        $Users_menu= Users_menu::select('id_user')->where( ['id_user' => $id] )->get();

        if ( $Users_menu->count() > 0){
            Users_menu::where('id_user', $id)->delete();
        }

        foreach ($request['menu'] as $key => $value) {
            $sql= array( 'id_user'=> $id, 'id_menu'=> $value);
            $users_menu = Users_menu::create( $sql );
        }

        return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));


    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_users_menu(Request $request)
    {
        if(!\Schema::hasTable('users_menu')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['id_user'=> trim($line)] ;

        }

        Users_menu::truncate();
        Users_menu::insert($data);

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
    public function get_users_menu_by_id(Request $request)
    {
        $data= Users_menu::select('id_user'
                                    , 'id_menu'
                                    , 'dt_fecha_limite'
        )->where('id_user', $request->id)->get();

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
    public function get_users_menu_by_datatable()
    {
        if(!\Schema::hasTable('users_menu')){
            return json_encode(array("data"=>"" ));
        }

        $data= Users_menu::select("id"
                                    , "id_user"
                                    , "id_menu"
                                    , "dt_fecha_limite"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->id_user
                            , $value->id_menu
                            , $value->dt_fecha_limite
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
    public function delete_users_menu(Request $request)
    {
        $id=$request->id;
        Users_menu::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_users_menu(Request $request)
    {
        $id=$request->id;
        Users_menu::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_users_menu()
    {
        Skynet::truncate();
    }
}
