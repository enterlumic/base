<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Lib\LibCore;

class UsersController extends Controller
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
    | Todo es controlado por JS usuarios.js
    |
    */
    public function index()
    {
        return view('usuarios');
    }



    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_usuarios_by_id(Request $request)
    {
        $data= Users::select('name'
                                    , 'email'
                                    , 'email_verified_at'
                                    , 'phone'
                                    , 'photo'
                                    , 'password'
                                    , 'remember_token'
                                    , 'created_at'
                                    , 'updated_at'
                                    , 'guid'
                                    , 'domain'
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
    public function get_usuarios_by_datatable(Request $request)
    {

        $data= Users::select("id"
                            , "name"
                            , "email"
                            , "email_verified_at"
                            , "phone"
                            , "photo"
                            , "password"
                            , "remember_token"
                            , "created_at"
                            , "updated_at"
                            , "guid"
                            , 'domain'
        )->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->name
                                , $value->email
                                , $value->email_verified_at
                                , $value->phone
                                , $value->photo
                                , $value->password
                                , $value->remember_token
                                , $value->created_at
                                , $value->updated_at
                                , $value->guid
                                , $value->domain
                                , $value->id
                );
            }
            $json_data = array(
                "draw"            => intval( 10 ),   
                "recordsTotal"    => intval( $total ),  
                "recordsFiltered" => intval( $total ),
                "data"            => isset($arr) && is_array($arr) ? $arr : ''
            );            
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
    public function delete_usuarios(Request $request)
    {
        $id=$request->id;
        Users::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_usuarios(Request $request)
    {
        $id=$request->id;
        Users::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_usuarios()
    {
        Users::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
