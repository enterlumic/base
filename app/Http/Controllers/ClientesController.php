<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\Clientes;
use App\Models\ClientesAdjuntos;
use App\Models\Clientes_comentarios;
use App\Lib\FileUploader;
use App\Lib\LibCore;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SkynetController;

class ClientesController extends Controller
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
    | Todo es controlado por JS clientes.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla clientes"));
        }

        return view('clientes');
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar pantalla para agregar un nuevo cliente
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS clientes.js
    |
    */
    public function nuevo_cliente()
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla clientes"));
        }

        return view('nuevo_cliente');
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
    public function set_clientes(Request $request)  
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Clientes"));
        }

        $data=[ 'vc_cliente' => $request->vc_cliente,
                'vc_correo' => $request->vc_correo,
                'vc_telefono' => $request->vc_telefono,
                'id_medio_contacto' => $request->id_medio_contacto,
                'id_red_social' => $request->id_red_social,
                'id_tipificacion' => $request->id_tipificacion,
                'id_subtipificacion' => $request->id_subtipificacion,
                'guia_o_id_envio' => $request->guia_o_id_envio,
                'id_carrier' => $request->id_carrier,
                'id_tipo_envio' => $request->id_tipo_envio,
                'vc_path_upload' => $request->vc_path_upload,
                'vc_comentarios' => $request->vc_comentarios,
                'id_status_interaccion' => $request->id_status_interaccion,
                'vc_whatsapp' => $request->vc_whatsapp,
                'vc_facebook' => $request->vc_facebook,
                'vc_instagram' => $request->vc_instagram,
                'id_user' => Auth::id(),
                'id_cliente' => intval($request->id_cliente)
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id) && $request->id > 0){
            
            $clientes = Clientes::where( ['id' => $request->id ] )->update($data );
            $this->uploadFiles($request->id);
            
            if ( !empty($request->vc_comentarios) ){
                $data_comentarios=[ 'id_cliente' => $request->id, 'id_user' => Auth::id(), 'vc_comentarios' => $request->vc_comentarios];
                Clientes_comentarios::create( $data_comentarios );
            }
            
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente'=>."));
        }else{ // Nuevo registro

            $clientes = Clientes::create( $data );

            $this->uploadFiles($clientes->id);
            if ( !empty($request->vc_comentarios) ){
                $data_comentarios=[ 'id_cliente' => $clientes->id, 'id_user' => Auth::id(), 'vc_comentarios' => $request->vc_comentarios];
                Clientes_comentarios::create( $data_comentarios );
            }

            return json_encode(array("b_status"=> true, "data" => ['id'=> $clientes->id ] ));
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
    public function get_clientes_by_id(Request $request)
    {
        $data= Clientes::select(      'vc_cliente'
                                    , 'vc_correo'
                                    , 'vc_telefono'
                                    , 'id_medio_contacto'
                                    , 'id_red_social'
                                    , 'id_tipificacion'
                                    , 'id_subtipificacion'
                                    , 'guia_o_id_envio'
                                    , 'id_carrier'
                                    , 'id_tipo_envio'
                                    , 'vc_path_upload'
                                    , 'id_status_interaccion'
                                    , 'vc_whatsapp'
                                    , 'vc_facebook'
                                    , 'vc_instagram'
                                    , 'id_user'
        )->where('id', $request->id)->get();

        $arr_comentarios= Clientes_comentarios::select('users.name', 'users.photo', 'vc_comentarios AS arr_comentarios', 'clientes_comentarios.created_at')
        ->leftjoin('users', 'users.id', '=', 'clientes_comentarios.id_user')
        ->where('id_cliente', $request->id)->orderBy('clientes_comentarios.id', 'desc')->get();

        foreach ($arr_comentarios as $key => $value) {
            if ( isset($arr_comentarios[$key]['photo']) && Storage::exists(  $arr_comentarios[$key]['photo']  )) {
                $arr_comentarios[$key]['photo'] = Storage::url( $arr_comentarios[$key]['photo'] );
            }else{
                $arr_comentarios[$key]['photo'] = 'assets/images/default-avatar.png';
            }
        }

        return json_encode(array("b_status"=> true, "data" => $data, "arr_comentarios" => $arr_comentarios));
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener "id" un registro por guia_o_id_envio
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function buscar_id_cliente($guia_o_id_envio)
    {
        $data= Clientes::select('id', 'id_cliente')->where('guia_o_id_envio', $guia_o_id_envio)->get();
        return isset($data[0]['id']) ? $data[0]['id'] : -1;
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por vc_telefono
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_clientes_by_vc_telefono($vc_telefono)
    {
        $vc_telefono = (int)filter_var($vc_telefono, FILTER_SANITIZE_NUMBER_INT);
        $data= Clientes::select('id', 'vc_telefono')->where('vc_telefono', $vc_telefono)->get();

        if ($data->count() > 0){
            return json_encode( array("b_status"=> true, "data" => $data) );
        }else{
            return json_encode( array("b_status"=> false) );
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
    public function get_clientes_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("data"=>"" ));
        }

        if(!\Schema::hasTable('clientes')){
            return json_encode(array("data"=>"" ));
        }

        $data= Clientes::select("clientes.id"
                                , "vc_cliente"
                                , "vc_correo"
                                , "vc_telefono"
                                , "vc_medio_contacto"
                                , "vc_red_social"
                                , "vc_tipificacion"
                                , "id_subtipificacion"
                                , "guia_o_id_envio"
                                , "id_carrier"
                                , "id_tipo_envio"
                                , 'vc_path_upload'
                                , 'vc_comentarios'
                                , 'vc_status'
                                , 'clientes.created_at'
                                , 'id_user'
        )
        ->leftJoin('cat_medio_contacto', 'cat_medio_contacto.id', '=', 'id_medio_contacto')
        ->leftJoin('cat_red_social', 'cat_red_social.id', '=', 'id_red_social')
        ->leftJoin('cat_tipificacion', 'cat_tipificacion.id', '=', 'id_tipificacion')
        ->leftJoin('cat_status_interaccion', 'cat_status_interaccion.id', '=', 'id_status_interaccion')
        ->where('clientes.id_cliente', $request->id_cliente > 0 ? $request->id_cliente : 0)
        ->orwhereRaw('vc_telefono = IF(vc_telefono <> NULL, vc_telefono, "'.$request->tel.'" )')
        ->orwhereRaw('vc_correo = IF(vc_correo <> NULL, vc_correo, "'.$request->tel.'" )')
        ->where('clientes.b_status', 1)
        ->orderBy('clientes.id', 'DESC')
        ->get()
        ;

        $total  = $data->count();
        
        if ($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->vc_cliente
                                , $value->vc_correo
                                , $value->vc_telefono
                                , $value->vc_medio_contacto
                                , $value->vc_tipificacion
                                , $value->guia_o_id_envio
                                , $value->id_carrier
                                , $value->id_tipo_envio
                                , $value->vc_status
                                , $value->created_at
                );
            }

            $json_data = array(
                "draw"            => intval( 10 ),   
                "recordsTotal"    => intval( $total ),  
                "recordsFiltered" => intval( $total ),
                "data"            => isset($arr) && is_array($arr)? $arr : ''
            );

            return json_encode($json_data);

        }else{

            return json_encode(array("data"=>"" ));

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable registro especial como se requiere en js (Mostrar todos)
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_clientes_by_datatable_all(Request $request)
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("data"=>"" ));
        }
        
        try {
            DB::select("show create procedure get_reporte");
        } catch(\Illuminate\Database\QueryException $ex){
            $sp_sql= file_get_contents(public_path()."/sp.sql");
            DB::statement($sp_sql);
        }

        $fecha= $this->LibCore->date_format($request->rango_fecha);
        $vc_search= isset($request->vc_search) ? $request->vc_search: '';
        
        $sql= "CALL get_reporte( '".$vc_search."', '".$fecha['dt_ini']."' , '".$fecha['dt_fin']."' , '".$request->id_status_interaccion."' )";

        $data = DB::select($sql);

        $this->LibCore->setSkynet(['vc_evento'=> 'sp_reporte' , 'vc_info' => $sql ] );

        foreach ($data as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_cliente
                            , $value->vc_correo
                            , $value->vc_telefono
                            , $value->vc_medio_contacto
                            , $value->vc_tipificacion
                            , $value->guia_o_id_envio
                            , $value->id_carrier
                            , $value->id_tipo_envio
                            , $value->vc_status
                            , $value->name
                            , $value->created_at
            );
        }

        $json_data = array(
            "draw"            => intval( 1000 ),   
            "recordsTotal"    => intval( 1000 ),  
            "recordsFiltered" => intval( 1000 ),
            "data"            => isset($arr) && is_array($arr)? $arr : ''
        );
        return json_encode($json_data);
    }

    /*
    |--------------------------------------------------------------------------
    | Datatable reporte Marketing
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_reporte_marketing(Request $request)
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("data"=>"" ));
        }
        
        try { 
            DB::select("show create procedure get_reporte");
        } catch(\Illuminate\Database\QueryException $ex){
            $sp_sql= file_get_contents(public_path()."/sp.sql");
            DB::statement($sp_sql);
        }

        try { 
            DB::select("show create procedure get_reporte_marketing");
        } catch(\Illuminate\Database\QueryException $ex){
            $sp_sql= file_get_contents(public_path()."/sp_marketing.sql");
            DB::statement($sp_sql);
        }

        $fecha= $this->LibCore->date_format($request->rango_fecha);
        $vc_search= isset($request->vc_search) ? $request->vc_search: '';

        $sql= "CALL get_reporte( '".$vc_search."', '".$fecha['dt_ini']."' , '".$fecha['dt_fin']."' , '".$request->id_status_interaccion."' )";
        $data = DB::select($sql);

        $this->LibCore->setSkynet(['vc_evento'=> 'sp_reporte' , 'vc_info' => $sql ] );

        foreach ($data as $key => $value) {

            $db = DB::connection('mysql_2')->select( "CALL get_reporte_marketing(".$value->id.")" );

            $arr[]= array(    $value->id
                            , $value->vc_cliente
                            , $value->vc_correo
                            , isset($db[0]->contenido) ? $db[0]->contenido : ''
                            , isset($db[0]->realiza_envio) ? $db[0]->realiza_envio : ''
                            , isset($db[0]->fecha_acreditacion) ? $db[0]->fecha_acreditacion : ''
                            , isset($db[0]->fecha_registro) ? $db[0]->fecha_registro : ''
                            , isset($db[0]->saldoAcreditacion) ? $db[0]->saldoAcreditacion : ''
                            , isset($db[0]->medio_de_contacto) ? $db[0]->medio_de_contacto : ''
                            , $value->name
            );

        }

        $json_data = array(
            "draw"            => intval( 1000 ),   
            "recordsTotal"    => intval( 1000 ),  
            "recordsFiltered" => intval( 1000 ),
            "data"            => isset($arr) && is_array($arr)? $arr : ''
        );

        // echo "<pre>";
        // print_r($json_data); 

        return json_encode($json_data);
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar registro por id
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function delete_clientes(Request $request)
    {
        $id=$request->id;
        
        // Eliminar archivos del registro
        $eliminar_archivos= ClientesAdjuntos::where('id_cliente','=',$id)->get()->pluck('file')->toArray();

        if ( is_array($eliminar_archivos) && count($eliminar_archivos) ){
            // ClientesAdjuntos::where('id_cliente','=',$id)->update(['id_cliente' => 9]);
            // foreach ($eliminar_archivos as $key => $value) {
            //     unlink(public_path('storage/').$value);
            // }
        }

        Clientes::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_clientes(Request $request)
    {
        $id=$request->id;
        Clientes::where('id', $id)->update(['b_status' => 1]);        
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
    public function cliente(Request $request, $id)
    {
        if(!\Schema::hasTable('clientes')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla clientes"));
        }

        return view('nuevo_cliente');
    }

    /*
    |--------------------------------------------------------------------------
    | adjuntar archivos
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function uploadFiles($id)
    {
        $field = 'files';
        $file_path= storage_path('app/public/') ;

        // initialize FileUploader
        $FileUploader = new FileUploader($field, array(
            'limit' => 100,
            'fileMaxSize' => 100,
            'extensions' => null,
            'uploadDir' => $file_path,
            'title' => 'auto'
        ));

        // upload
        $upload = $FileUploader->upload();
        if ($upload['isSuccess']) {

            foreach($upload['files'] as $key=>$item) {

                $is_main=ClientesAdjuntos::Raw('IFNULL((SELECT MAX(`index_img`) FROM clientes_adjuntos g),-1)')->pluck('is_main')->toArray();

                $data= [ 'id_cliente'=>$id
                        ,'title'=>$item['name']
                        ,'file'=>$item['name']
                        ,'type'=>$item['type']
                        ,'size'=>$item['size']
                        ,'index_img'=>$key
                        ,'is_main'=> isset( $is_main[0] ) ? $is_main[0] : 0
                        ,'date'=> date("Y-m-d H:i:s")
                    ];

                ClientesAdjuntos::create( $data );
                $this->LibCore->setSkynet(['vc_evento'=> 'ClientesAdjuntos::create' , 'vc_info' => json_encode( DB::getQueryLog(), JSON_PRETTY_PRINT) , '_truncate_' => false] );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | pre cargar archivos cuando se edita!
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function preUpload(Request $request)
    {
        $preloadedFiles = array();

        $query = ClientesAdjuntos::where('id_cliente','=', $request->id)
                ->orderBy('index_img','ASC')
                ->get()->toArray();


        if ($query ) {
            foreach ($query as $key => $row) {
                $file_path = Storage::url($row['file']);
                $preloadedFiles[] = array(
                    'name' => $row['title'],
                    'type' => $row['type'],
                    'size' => $row['size'],
                    'file' => $file_path,
                    'data' => array(
                        'readerForce' => true,
                        'url' => $row['file'],
                        'date' => $row['date'],
                        'isMain' => $row['is_main'],
                        'listProps' => array(
                            'id' => $row['id'],
                        )
                    ),
                );
            }

            $this->LibCore->setSkynet(['vc_evento'=> 'ClientesAdjuntos::where' , 'vc_info' => json_encode( $preloadedFiles ) , '_truncate_' => false] );

            return json_encode($preloadedFiles);              
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Eliminar archivos de un cliente!
    |--------------------------------------------------------------------------
    | 
    | @return id
    |
    */
    public function removeAdjuntos(Request $request)
    {
        $id= $request->id;
        $name= $request->name;

        if (isset( $id ) && isset($name)) {

            $query = ClientesAdjuntos::where('id','=', $id) ->pluck('file')->toArray();

            if (isset($query[0])) {
                ClientesAdjuntos::where('id','=',$id)->delete();
                if (is_file(public_path('storage/').$name)){
                    unlink(public_path('storage/').$name);
                }
            }
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Reordenar las imagenes
    |--------------------------------------------------------------------------
    | 
    */
    public function sortAdjuntos(Request $request)
    {

        if (isset($request->list)) {
            $list = json_decode($request->list, true);
            
            $index = 0;
            foreach($list as $val) {
                if (!isset($val['id']) || !isset($val['name']) || !isset($val['index']))
                    break;
                    
                    ClientesAdjuntos::where( ['id' => $val['id'] ] )->update( ['index_img'=> $index] );

                $index++;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Crear archivos
    |--------------------------------------------------------------------------
    |
    */
    public function crear_archivos($arr)
    {

        // Archivo donde se guardan los datos para formar el Excel
        if (Storage::exists('public/json_data.json')){
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }else{
            Storage::disk('public')->put('json_data.json', json_encode($arr));
        }
    }

}
