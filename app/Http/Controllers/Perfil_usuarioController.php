<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Perfil_usuario;
use App\Lib\FileUploader;
use App\Lib\LibCore;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SkynetController;

class Perfil_usuarioController extends Controller
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
    | Todo es controlado por JS perfil_usuario.js
    |
    */
    public function index()
    {
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_Perfil_usuarioController' , 'vc_info' => "index - Perfil_usuarioController" ] );

        return view('perfil_usuario');
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
    public function set_perfil_usuario(Request $request)
    {
        $data=[ 'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
        ];

        if (isset($request->id)){
            $perfil_usuario = Perfil_usuario::where( ['id' => $request->id])->update($data );
            $this->LibCore->setSkynet(['vc_evento'=> 'set_perfil_usuario' , 'vc_info' => json_encode( $data, JSON_PRETTY_PRINT) ] );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
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
    public function get_perfil_usuario_by_id(Request $request)
    {
        $data= Perfil_usuario::select('name'
                                    , 'photo'
                                    , 'email'
                                    , 'phone'
        )->where('id', Auth::id() )->get();

        if (    $data->count() > 0 
            &&  isset($data[0]['photo']) 
            &&  !is_null($data[0]['photo']) 
            &&  Storage::exists( $data[0]['photo'] ))
        {

            $data[0]['photo']=    Storage::exists( $data[0]['photo'] ) 
                                ? Storage::url( $data[0]['photo'] ) 
                                : 'assets/images/default-avatar.png';

            return json_encode(array("b_status"=> true, "data" => $data));
        }else{
            return json_encode(array("b_status"=> false, "vc_message" => "No se pudo encontrar foto de perfil"));            
        }
    }

    /*
    |--------------------------------------------------------------------------
    | adjuntar archivos
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function uploadFiles(Request $request)
    {
        $path = Storage::putFile( 'public/avatars/', $request->file('avatar') );
        if (!empty($path)){
            $this->LibCore->setSkynet(['vc_evento'=> 'uploadFiles' , 'vc_info' => "<b>Cambiando foto de perfil ok </b> ". $path ] );
            $eliminarFotoPerfil= $this->eliminarFotoPerfil();
            $this->LibCore->setSkynet(['vc_evento'=> 'eliminarFotoPerfil' , 'vc_info' => $eliminarFotoPerfil ] );
            Users::where( ['id' => Auth::id() ])->update( [ 'photo' =>  $path ] );
            return json_encode(array("b_status"=> true, "data" => [ "vc_path" =>  Storage::url( $path )  ] ));
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
    public function get_perfil_usuario_by_datatable()
    {
        if(!\Schema::hasTable('perfil_usuario')){
            return json_encode(array("data"=>"" ));
        }

        $data= Perfil_usuario::select("id"
                                    , "name"
                                    , "photo"
                                    , "email"
                                    , "phone"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->name
                            , $value->photo
                            , $value->email
                            , $value->phone
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
    public function delete_perfil_usuario(Request $request)
    {
        $id=$request->id;
        Perfil_usuario::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_perfil_usuario(Request $request)
    {
        $id=$request->id;
        Perfil_usuario::where('id', $id)->update(['b_status' => 1]);        
        return $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar foto de perfil
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function eliminarFotoPerfil()
    {
        $Users= Users::select('photo')->where( ['id' => Auth::id() ])->pluck( 'photo' )->first();
        if ( !is_null($Users) && Storage::exists( $Users )){
            Storage::delete($Users);
            return "<b>Borrando...</b>  " . $Users;
        }
        return "<b> No se pudo encontrar alguna foto </b>";
    }

}
