<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Envio;
use App\Models\TipoEnvio;
use App\Models\CatProveedores;
use App\Models\Clientes;
use App\Lib\LibCore;
use App\Http\Controllers\Clientes_telefonosController;
use App\Http\Controllers\ClientesController;

class ApiTeiker extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;
    public $SkynetController;
    public $Clientes_telefonos;
    public $ClientesController;
    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(){
        $this->LibCore = new LibCore();
        $this->Clientes_telefonos = new Clientes_telefonosController();
        $this->ClientesController = new ClientesController();
    }

    /*
    |--------------------------------------------------------------------------
    | Buscar el número de teléfono del cliente
    | 1. Buscar en BD Teiker
    | 2. Buscar en BD CX
    |--------------------------------------------------------------------------
    |
    */
    public function set_buscar_telefono(Request $request)
    {
        $buscando='';
        $vc_telefono= isset($request->vc_telefono) ? $request->vc_telefono : 0;
        
        $qs = parse_url($_SERVER['HTTP_REFERER'] , PHP_URL_QUERY);
        if(!empty($qs)){
            parse_str($qs, $output);
            $buscando= isset($output['buscando']) ? $output['buscando'] : '';
        }

        if ( isset($buscando) && $buscando > 0 ){
            $this->LibCore->setSkynet( ['vc_evento'=> 'buscando_formulario' , 'vc_info' => "buscando_telefono - ApiTeiker .... <b>".$vc_telefono."</b>" ] );
        }

        $getUser= $this->set_buscar_telefono_tieker($request);
        $getUser= json_decode($getUser, true);

        if ( $getUser['b_status'] ){

            // Extraer datos para llenar el dashboard
            $get_dashboard= $this->get_dashboard($getUser['data'][0]['id_cliente']);

            $this->LibCore->setSkynet( ['vc_evento'=> 'telefono_encontrado' , 'vc_info' => "teléfono encontrado - ApiTeiker ... ".$vc_telefono ] );

            // Si es un teleno que se esta buscando y aun no existe guardar
            if ( isset($request->tel) ){
                $this->LibCore->setSkynet( ['vc_evento'=> 'telefono_nuevo_guardando' , 'vc_info' => "Teléfono nuevo, guardando - ApiTeiker... <b>".$vc_telefono ."</b>"  ] );
                $request->merge( [ 'vc_telefono' => $request->tel ]  );
            }

            // Guarda en bd CX (valida si aun no existe)
            $set_vc_telefono_cx= $this->set_vc_telefono_cx($request, $getUser);

            $data= array_merge($getUser['data'], $get_dashboard);
            return json_encode( array("b_status"=> true, "se_encontro_en_bd_teiker"=> true, "data" => $data) );

        }else{

            $data= $this->Clientes_telefonos->get_clientes_telefonos_by_telefono($vc_telefono);
            $data= json_decode($data, true);

            $id_cliente= isset( $data['data'][0]['id_cliente'] ) ? intval($data['data'][0]['id_cliente']) : 0 ;
            if ( $id_cliente > 0 && $vc_telefono > 0){
                $this->LibCore->setSkynet( ['vc_evento'=> 'telefono_encontrado_en_cat' , 'vc_info' => "id_cliente encontrado - ApiTeiker... <b>". $id_cliente ."</b>"  ] );

                $get_dashboard= $this->get_dashboard( $data['data'][0]['id_cliente'] );                
                $getUser= $this->get_user_by_id( $data['data'][0]['id_cliente'] );
                $getUser= json_decode($getUser, true);

                $data= array_merge($getUser['data'], $get_dashboard);
                return json_encode( array("b_status"=> true, "se_encontro_en_bd_teiker"=> true, "data" => $data) );
            }

            $buscar_telefono= $this->ClientesController->get_clientes_by_vc_telefono($request->vc_telefono);
    

            $buscar_telefono= json_decode($buscar_telefono, true);

            if ( $buscar_telefono['b_status'] ){
                
                $arr['vc_evento']= 'telefono_previo_guardado';
                $arr['vc_info']  = 'previo guardado id_cliente - ApiTeiker... <b>'. $buscar_telefono['data'][0]['id'] .'</b>';
                $this->LibCore->setSkynet( $arr );

                $data= $this->Clientes_telefonos->get_clientes_telefonos_by_telefono($buscar_telefono['data'][0]['vc_telefono']);
                $data= json_decode($data, true);

                return json_encode( array("buscar_por_telefono"=> true, 'id_cliente'=> $buscar_telefono['data'][0]['id'], 'data'=> $data ) );   
            }
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'no_encontrado' 
            , 'vc_info' => "En todos los casos no se encontro - ApiTeiker... <b>". $vc_telefono ."</b>"  ] 
        );

        // En todos los casos no se encontro
        return json_encode(array("b_status"=> false, "se_encontro_en_bd_teiker"=> false, "data" => ''));
    }

    /*
    |--------------------------------------------------------------------------
    | Buscar en BD Teiker
    |--------------------------------------------------------------------------
    */
    public function set_buscar_telefono_tieker(Request $request)
    {
        $User = new User();
        $User->setConnection('mysql_2');
        $getUser= $User->select(    DB::raw('id AS id_cliente')
                                ,   DB::raw('CONCAT(name, " ", apellido) as vc_cliente')
                                ,   'email AS vc_correo'
                                ,   'telefono AS vc_telefono'
                            )
                    ->where('telefono', $request->vc_telefono)
                    ->orwhere('email', $request->vc_telefono)
                    ->get();

        if ($getUser->count() > 0 && $request->vc_telefono > 0){
            return json_encode(array("b_status"=> true, "data" => $getUser->toArray()));
        }else{
            return json_encode(array("b_status"=> false, "data" => ''));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Buscar Usuario por ID en BD Teiker
    |--------------------------------------------------------------------------
    */
    public function get_user_by_id($id)
    {
        $User = new User();
        $User->setConnection('mysql_2');
        $getUser= $User->select(    DB::raw('id AS id_cliente')
                                ,   DB::raw('CONCAT(name, " ", apellido) as vc_cliente')
                                ,   'email AS vc_correo'
                                ,   'telefono AS vc_telefono'
                            )
                    ->where('id', $id)
                    ->get();

        if ($getUser->count() > 0){
            return json_encode(array("b_status"=> true, "data" => $getUser->toArray()));
        }else{
            return json_encode(array("b_status"=> false, "data" => ''));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar en bd CX
    |--------------------------------------------------------------------------
    */
    public function set_vc_telefono_cx($request, $getUser)
    {

        if ( isset($request->tel) && is_numeric($request->tel) ){
            $vc_telefono= $request->vc_telefono;
            $this->LibCore->setSkynet(['vc_evento'=> 'usuario_nuevo' , 'vc_info' => $request->all() , '_truncate_' => false ] );
        }else{
            $this->LibCore->setSkynet(['vc_evento'=> 'usuario_encontrado' , 'vc_info' => $request->all() , '_truncate_' => false ] );
            $vc_telefono= $getUser['data'][0]['vc_telefono'];
        }

        if (isset($getUser['data'][0]['id_cliente']) && $getUser['data'][0]['id_cliente'] > 0){
            $request->merge( [ 'id_cliente' => $getUser['data'][0]['id_cliente'] , 'vc_telefono' => $vc_telefono ] );
            $this->Clientes_telefonos->set_clientes_telefonos($request);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Buscar la guía ó el id del envio
    | Es para mostrar cuando se realiza una busqueda
    |--------------------------------------------------------------------------
    |
    */
    public function set_buscar_guia_o_id_envio(Request $request)
    {
        $Envio = new Envio();
        $Envio->setConnection('mysql_2');

        $TipoEnvio = new TipoEnvio();
        $TipoEnvio->setConnection('mysql_2');

        $CatProveedores = new CatProveedores();
        $CatProveedores->setConnection('mysql_2');

        $getEnvio= $Envio->select('IdTipoEnvio'
                                , 'IdTookan'
                                , 'IdTookanD'
                                , 'IdEstafeta'
                                , 'IdFedex'
                                , 'IdRedpack'
                                , 'IdPaquetexpress'
                                , 'IdSendex'
                                , 'IdDHL'
                                , 'IdJT'
                    )
                    ->where('IdEnvio', $request->buscar_guia_o_id_envio)
                    ->orWhere('Guia', $request->buscar_guia_o_id_envio)
                    ->get();

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
        )->where('guia_o_id_envio', $request->buscar_guia_o_id_envio)->get();

        $buscar_id_cliente= $this->ClientesController->buscar_id_cliente($request->buscar_guia_o_id_envio);
        $getEnvio['id_cliente']= $buscar_id_cliente;

        if(isset($getEnvio[0]['IdTipoEnvio']) && !empty($getEnvio[0]['IdTipoEnvio'])){

            $tipo_envio= $TipoEnvio->where('Id', $getEnvio[0]['IdTipoEnvio'])->first();
            $carrier   = $CatProveedores->where('id',  isset($tipo_envio['IdProveedor']) ? $tipo_envio['IdProveedor'] : 0 )->first();

            $getEnvio[0]['tipo_envio']= isset($tipo_envio['label']) ? $tipo_envio['label'] : 0;
            $getEnvio[0]['carrier']= isset($carrier['proveedor']) ? $carrier['proveedor'] : 0;

            $getEnvio = array_filter($getEnvio->toArray()[0]);

            if (is_array($getEnvio) && !empty($getEnvio)){
                return json_encode(array("b_status"=> true, "data" => $getEnvio));
            }

        }else if ($buscar_id_cliente > 0){
            return json_encode(array("b_status"=> true, "data" => $getEnvio));
        }

        // Error
        return json_encode( array("b_status"=> false, "data" => '') );

    }

    public function get_dashboard($id_user){

        if ($id_user > 0){
            // Busqueda en BD teiker
            $response = Http::get('https://dev.tecc.app/teiker_v2/public/api/getDashboard', ['id_user' => $id_user ]);

            $response= array_merge(json_decode($response, true), ["id_cliente"=> $id_user]);

            return $response;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Guardar metrica para saber cuantas veces usaron el buscador
    |--------------------------------------------------------------------------
    |
    */
    public function usando_buscador_en_formulario()
    {
        $qs = parse_url($_SERVER['HTTP_REFERER'] , PHP_URL_QUERY);
        if(!empty($qs)){
            parse_str($qs, $output);
            $buscando= $output['buscando'];
        }

        if ( isset($buscando) && $buscando > 0 ){
            $this->LibCore->setSkynet( ['vc_evento'=> 'buscando_telefono' , 'vc_info' => "buscando_telefono - ApiTeiker .... <b>".$vc_telefono."</b>" ] );
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Datos para reporte de Marketing
    |--------------------------------------------------------------------------
    */
    public function get_datos_reporte_marqueting(Request $request)
    {
        $User = new User();
        $User->setConnection('mysql_2');
        $getUser= $User->select(    DB::raw('id AS id_cliente')
                                ,   DB::raw('CONCAT(name, " ", apellido) as vc_cliente')
                                ,   'email AS vc_correo'
                                ,   'telefono AS vc_telefono'
                            )
                    ->where('telefono', $request->vc_telefono)
                    ->orwhere('email', $request->vc_telefono)
                    ->get();

        if ($getUser->count() > 0 && $request->vc_telefono > 0){
            return json_encode(array("b_status"=> true, "data" => $getUser->toArray()));
        }else{
            return json_encode(array("b_status"=> false, "data" => ''));
        }
    }
}
