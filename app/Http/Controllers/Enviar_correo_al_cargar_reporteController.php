<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Enviar_correo_al_cargar_reporte;
use App\Lib\LibCore;

class Enviar_correo_al_cargar_reporteController extends Controller
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
    | Todo es controlado por JS enviar_correo_al_cargar_reporte.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('enviar_correo_al_cargar_reporte')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla enviar_correo_al_cargar_reporte"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_enviar_correo_al_cargar_reporte' , 'vc_info' => "index - enviar_correo_al_cargar_reporte" ] );

        return view('enviar_correo_al_cargar_reporte');
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
    public function set_enviar_correo_al_cargar_reporte(Request $request)
    {
        if(!\Schema::hasTable('enviar_correo_al_cargar_reporte')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Enviar_correo_al_cargar_reporte"));
        }

        $data=[ 'vc_correo' => $request->vc_correo,
                'id_cat_reporte' => $request->id_cat_reporte,
                'dt_fecha_personalizado' => $request->dt_fecha_personalizado,
                'dt_fecha_inicial' => $request->dt_fecha_inicial,
                'vc_fecha_final' => $request->vc_fecha_final,
                'vc_api_whatsapp' => $request->vc_api_whatsapp,
                'vc_telefono' => $request->vc_telefono,
                'vCampo8_enviar_correo_al_cargar_reporte' => $request->vCampo8_enviar_correo_al_cargar_reporte,
                'vCampo9_enviar_correo_al_cargar_reporte' => $request->vCampo9_enviar_correo_al_cargar_reporte,
                'vCampo10_enviar_correo_al_cargar_reporte' => $request->vCampo10_enviar_correo_al_cargar_reporte,
                'vCampo11_enviar_correo_al_cargar_reporte' => $request->vCampo11_enviar_correo_al_cargar_reporte,
                'vCampo12_enviar_correo_al_cargar_reporte' => $request->vCampo12_enviar_correo_al_cargar_reporte,
                'vCampo13_enviar_correo_al_cargar_reporte' => $request->vCampo13_enviar_correo_al_cargar_reporte,
                'vCampo14_enviar_correo_al_cargar_reporte' => $request->vCampo14_enviar_correo_al_cargar_reporte,
                'vCampo15_enviar_correo_al_cargar_reporte' => $request->vCampo15_enviar_correo_al_cargar_reporte,
                'vCampo16_enviar_correo_al_cargar_reporte' => $request->vCampo16_enviar_correo_al_cargar_reporte,
                'vCampo17_enviar_correo_al_cargar_reporte' => $request->vCampo17_enviar_correo_al_cargar_reporte,
                'vCampo18_enviar_correo_al_cargar_reporte' => $request->vCampo18_enviar_correo_al_cargar_reporte,
                'vCampo19_enviar_correo_al_cargar_reporte' => $request->vCampo19_enviar_correo_al_cargar_reporte,
                'vCampo20_enviar_correo_al_cargar_reporte' => $request->vCampo20_enviar_correo_al_cargar_reporte,
                'vCampo21_enviar_correo_al_cargar_reporte' => $request->vCampo21_enviar_correo_al_cargar_reporte,
                'vCampo22_enviar_correo_al_cargar_reporte' => $request->vCampo22_enviar_correo_al_cargar_reporte,
                'vCampo23_enviar_correo_al_cargar_reporte' => $request->vCampo23_enviar_correo_al_cargar_reporte,
                'vCampo24_enviar_correo_al_cargar_reporte' => $request->vCampo24_enviar_correo_al_cargar_reporte,
                'vCampo25_enviar_correo_al_cargar_reporte' => $request->vCampo25_enviar_correo_al_cargar_reporte,
                'vCampo26_enviar_correo_al_cargar_reporte' => $request->vCampo26_enviar_correo_al_cargar_reporte,
                'vCampo27_enviar_correo_al_cargar_reporte' => $request->vCampo27_enviar_correo_al_cargar_reporte,
                'vCampo28_enviar_correo_al_cargar_reporte' => $request->vCampo28_enviar_correo_al_cargar_reporte,
                'vCampo29_enviar_correo_al_cargar_reporte' => $request->vCampo29_enviar_correo_al_cargar_reporte,
                'vCampo30_enviar_correo_al_cargar_reporte' => $request->vCampo30_enviar_correo_al_cargar_reporte,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $enviar_correo_al_cargar_reporte = Enviar_correo_al_cargar_reporte::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $enviar_correo_al_cargar_reporte = Enviar_correo_al_cargar_reporte::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_enviar_correo_al_cargar_reporte(Request $request)
    {
        if(!\Schema::hasTable('enviar_correo_al_cargar_reporte')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_enviar_correo_al_cargar_reporte' , 'vc_info' => "set_import_enviar_correo_al_cargar_reporte" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['vc_correo'=> trim($line)] ;

        }

        Enviar_correo_al_cargar_reporte::truncate();
        Enviar_correo_al_cargar_reporte::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_enviar_correo_al_cargar_reporte()
    {
        if (file_exists($this->input->post()['path']))
        {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($this->input->post()['path']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            if (is_array($sheetData) && count($sheetData) > 0)
            {
                unset($arr);
                foreach ($sheetData as $key => $value)
                {
                    if ($key > 2 && !empty($value['A']))
                    {
                        $arr[]= array(   "vc_correo"  => $value['A']
                                        ,"id_cat_reporte"  => $value['B']
                                        ,"dt_fecha_personalizado"  => $value['D']
                                        ,"dt_fecha_inicial"  => $value['C']
                                        ,"vc_fecha_final"  => $value['E']
                                        ,"vc_api_whatsapp"  => $value['F']
                                        ,"vc_telefono"  => $value['G']
                                        ,"vCampo8_enviar_correo_al_cargar_reporte"  => $value['H']
                                        ,"vCampo9_enviar_correo_al_cargar_reporte"  => $value['I']
                                        ,"vCampo10_enviar_correo_al_cargar_reporte" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Enviar_correo_al_cargar_reporte_model->importar_enviar_correo_al_cargar_reporte($arr);
            print_r($result);
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
    public function get_enviar_correo_al_cargar_reporte_by_id(Request $request)
    {
        $data= Enviar_correo_al_cargar_reporte::select('vc_correo'
                                    , 'id_cat_reporte'
                                    , 'dt_fecha_personalizado'
                                    , 'dt_fecha_inicial'
                                    , 'vc_fecha_final'
                                    , 'vc_api_whatsapp'
                                    , 'vc_telefono'
                                    , 'vCampo8_enviar_correo_al_cargar_reporte'
                                    , 'vCampo9_enviar_correo_al_cargar_reporte'
                                    , 'vCampo10_enviar_correo_al_cargar_reporte'
                                    , 'vCampo11_enviar_correo_al_cargar_reporte'
                                    , 'vCampo12_enviar_correo_al_cargar_reporte'
                                    , 'vCampo13_enviar_correo_al_cargar_reporte'
                                    , 'vCampo14_enviar_correo_al_cargar_reporte'
                                    , 'vCampo15_enviar_correo_al_cargar_reporte'
                                    , 'vCampo16_enviar_correo_al_cargar_reporte'
                                    , 'vCampo17_enviar_correo_al_cargar_reporte'
                                    , 'vCampo18_enviar_correo_al_cargar_reporte'
                                    , 'vCampo19_enviar_correo_al_cargar_reporte'
                                    , 'vCampo20_enviar_correo_al_cargar_reporte'
                                    , 'vCampo21_enviar_correo_al_cargar_reporte'
                                    , 'vCampo22_enviar_correo_al_cargar_reporte'
                                    , 'vCampo23_enviar_correo_al_cargar_reporte'
                                    , 'vCampo24_enviar_correo_al_cargar_reporte'
                                    , 'vCampo25_enviar_correo_al_cargar_reporte'
                                    , 'vCampo26_enviar_correo_al_cargar_reporte'
                                    , 'vCampo27_enviar_correo_al_cargar_reporte'
                                    , 'vCampo28_enviar_correo_al_cargar_reporte'
                                    , 'vCampo29_enviar_correo_al_cargar_reporte'
                                    , 'vCampo30_enviar_correo_al_cargar_reporte'
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
    public function get_enviar_correo_al_cargar_reporte_by_datatable()
    {
        if(!\Schema::hasTable('enviar_correo_al_cargar_reporte')){
            return json_encode(array("data"=>"" ));
        }

        $data= Enviar_correo_al_cargar_reporte::select("id"
                                    , "vc_correo"
                                    , "id_cat_reporte"
                                    , "dt_fecha_personalizado"
                                    , "dt_fecha_inicial"
                                    , "vc_fecha_final"
                                    , "vc_api_whatsapp"
                                    , "vc_telefono"
                                    , "vCampo8_enviar_correo_al_cargar_reporte"
                                    , "vCampo9_enviar_correo_al_cargar_reporte"
                                    , "vCampo10_enviar_correo_al_cargar_reporte"
                                    , 'vCampo11_enviar_correo_al_cargar_reporte'
                                    , 'vCampo12_enviar_correo_al_cargar_reporte'
                                    , 'vCampo13_enviar_correo_al_cargar_reporte'
                                    , 'vCampo14_enviar_correo_al_cargar_reporte'
                                    , 'vCampo15_enviar_correo_al_cargar_reporte'
                                    , 'vCampo16_enviar_correo_al_cargar_reporte'
                                    , 'vCampo17_enviar_correo_al_cargar_reporte'
                                    , 'vCampo18_enviar_correo_al_cargar_reporte'
                                    , 'vCampo19_enviar_correo_al_cargar_reporte'
                                    , 'vCampo20_enviar_correo_al_cargar_reporte'
                                    , 'vCampo21_enviar_correo_al_cargar_reporte'
                                    , 'vCampo22_enviar_correo_al_cargar_reporte'
                                    , 'vCampo23_enviar_correo_al_cargar_reporte'
                                    , 'vCampo24_enviar_correo_al_cargar_reporte'
                                    , 'vCampo25_enviar_correo_al_cargar_reporte'
                                    , 'vCampo26_enviar_correo_al_cargar_reporte'
                                    , 'vCampo27_enviar_correo_al_cargar_reporte'
                                    , 'vCampo28_enviar_correo_al_cargar_reporte'
                                    , 'vCampo29_enviar_correo_al_cargar_reporte'
                                    , 'vCampo30_enviar_correo_al_cargar_reporte'
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_correo
                            , $value->id_cat_reporte
                            , $value->dt_fecha_personalizado
                            , $value->dt_fecha_inicial
                            , $value->vc_fecha_final
                            , $value->vc_api_whatsapp
                            , $value->vc_telefono
                            , $value->vCampo8_enviar_correo_al_cargar_reporte
                            , $value->vCampo9_enviar_correo_al_cargar_reporte
                            , $value->vCampo10_enviar_correo_al_cargar_reporte
                            , $value->vCampo11_enviar_correo_al_cargar_reporte
                            , $value->vCampo12_enviar_correo_al_cargar_reporte
                            , $value->vCampo13_enviar_correo_al_cargar_reporte
                            , $value->vCampo14_enviar_correo_al_cargar_reporte
                            , $value->vCampo15_enviar_correo_al_cargar_reporte
                            , $value->vCampo16_enviar_correo_al_cargar_reporte
                            , $value->vCampo17_enviar_correo_al_cargar_reporte
                            , $value->vCampo18_enviar_correo_al_cargar_reporte
                            , $value->vCampo19_enviar_correo_al_cargar_reporte
                            , $value->vCampo20_enviar_correo_al_cargar_reporte
                            , $value->vCampo21_enviar_correo_al_cargar_reporte
                            , $value->vCampo22_enviar_correo_al_cargar_reporte
                            , $value->vCampo23_enviar_correo_al_cargar_reporte
                            , $value->vCampo24_enviar_correo_al_cargar_reporte
                            , $value->vCampo25_enviar_correo_al_cargar_reporte
                            , $value->vCampo26_enviar_correo_al_cargar_reporte
                            , $value->vCampo27_enviar_correo_al_cargar_reporte
                            , $value->vCampo28_enviar_correo_al_cargar_reporte
                            , $value->vCampo29_enviar_correo_al_cargar_reporte
                            , $value->vCampo30_enviar_correo_al_cargar_reporte
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
    public function delete_enviar_correo_al_cargar_reporte(Request $request)
    {
        $id=$request->id;
        Enviar_correo_al_cargar_reporte::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_enviar_correo_al_cargar_reporte(Request $request)
    {
        $id=$request->id;
        Enviar_correo_al_cargar_reporte::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_enviar_correo_al_cargar_reporte()
    {
        Enviar_correo_al_cargar_reporte::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
