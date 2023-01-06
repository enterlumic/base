<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Conexiones_metricas_formulas;
use App\Lib\LibCore;

class Conexiones_metricas_formulasController extends Controller
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
    | Todo es controlado por JS conexiones_metricas_formulas.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('conexiones_metricas_formulas')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla conexiones_metricas_formulas"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_conexiones_metricas_formulas' , 'vc_info' => "index - conexiones_metricas_formulas" ] );

        return view('conexiones_metricas_formulas');
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
    public function set_conexiones_metricas_formulas($key, $request)
    {
        if(!\Schema::hasTable('conexiones_metricas_formulas')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Conexiones_metricas_formulas"));
        }
        return [ 'wait_calling' => ['wait_calling']
                , 'wait_calling_login_time' => ['wait_calling_login_time']
                , 'tiempo_entre_llamdadas' => ['tiempo_entre_llamdadas']
                , 'break_banio' => ['break_banio']
                , 'break_banio_login_time' => ['break_banio_login_time']
                , 'llamadas_por_hora_promedio' => ['llamadas_por_hora_promedio']
                , 'talk' => ['talk']
                , 'tiempo_entre_llamdadas_permitidos' => ['tiempo_entre_llamdadas_permitidos']
                , 'billable' => ['billable']
                , 'horas_laborables' => ['horas_laborables']
                , 'billable_entre_tiempo' => ['billable_entre_tiempo']
                , 'hrs_tope_facturable' => ['hrs_tope_facturable']
                , 'conversacion' => ['conversacion']
                , 'decimal' => ['decimal']
                , 'rol' => ['rol']
                , 'campania' => ['campania']
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_conexiones_metricas_formulas(Request $request)
    {
        if(!\Schema::hasTable('conexiones_metricas_formulas')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_conexiones_metricas_formulas' , 'vc_info' => "set_import_conexiones_metricas_formulas" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['wait_calling'=> trim($line)] ;

        }

        Conexiones_metricas_formulas::truncate();
        Conexiones_metricas_formulas::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_conexiones_metricas_formulas()
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
                        $arr[]= array(   "wait_calling"  => $value['A']
                                        ,"wait_calling_login_time"  => $value['B']
                                        ,"tiempo_entre_llamdadas"  => $value['D']
                                        ,"break_banio"  => $value['C']
                                        ,"break_banio_login_time"  => $value['E']
                                        ,"llamadas_por_hora_promedio"  => $value['F']
                                        ,"talk"  => $value['G']
                                        ,"tiempo_entre_llamdadas_permitidos"  => $value['H']
                                        ,"billable"  => $value['I']
                                        ,"horas_laborables" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Conexiones_metricas_formulas_model->importar_conexiones_metricas_formulas($arr);
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
    public function get_conexiones_metricas_formulas_by_id(Request $request)
    {
        $data= Conexiones_metricas_formulas::select('wait_calling'
                                    , 'wait_calling_login_time'
                                    , 'tiempo_entre_llamdadas'
                                    , 'break_banio'
                                    , 'break_banio_login_time'
                                    , 'llamadas_por_hora_promedio'
                                    , 'talk'
                                    , 'tiempo_entre_llamdadas_permitidos'
                                    , 'billable'
                                    , 'horas_laborables'
                                    , 'billable_entre_tiempo'
                                    , 'hrs_tope_facturable'
                                    , 'conversacion'
                                    , 'decimal'
                                    , 'rol'
                                    , 'campania'
                                    , 'vCampo17_conexiones_metricas_formulas'
                                    , 'vCampo18_conexiones_metricas_formulas'
                                    , 'vCampo19_conexiones_metricas_formulas'
                                    , 'vCampo20_conexiones_metricas_formulas'
                                    , 'vCampo21_conexiones_metricas_formulas'
                                    , 'vCampo22_conexiones_metricas_formulas'
                                    , 'vCampo23_conexiones_metricas_formulas'
                                    , 'vCampo24_conexiones_metricas_formulas'
                                    , 'vCampo25_conexiones_metricas_formulas'
                                    , 'vCampo26_conexiones_metricas_formulas'
                                    , 'vCampo27_conexiones_metricas_formulas'
                                    , 'vCampo28_conexiones_metricas_formulas'
                                    , 'vCampo29_conexiones_metricas_formulas'
                                    , 'vCampo30_conexiones_metricas_formulas'
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
    public function get_conexiones_metricas_formulas_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('conexiones_metricas_formulas')){
            return json_encode(array("data"=>"" ));
        }

        $data= Conexiones_metricas_formulas::select("id"
                                    , "wait_calling"
                                    , "wait_calling_login_time"
                                    , "tiempo_entre_llamdadas"
                                    , "break_banio"
                                    , "break_banio_login_time"
                                    , "llamadas_por_hora_promedio"
                                    , "talk"
                                    , "tiempo_entre_llamdadas_permitidos"
                                    , "billable"
                                    , "horas_laborables"
                                    , 'billable_entre_tiempo'
                                    , 'hrs_tope_facturable'
                                    , 'conversacion'
                                    , 'decimal'
                                    , 'rol'
                                    , 'campania'
                                    , 'vCampo17_conexiones_metricas_formulas'
                                    , 'vCampo18_conexiones_metricas_formulas'
                                    , 'vCampo19_conexiones_metricas_formulas'
                                    , 'vCampo20_conexiones_metricas_formulas'
                                    , 'vCampo21_conexiones_metricas_formulas'
                                    , 'vCampo22_conexiones_metricas_formulas'
                                    , 'vCampo23_conexiones_metricas_formulas'
                                    , 'vCampo24_conexiones_metricas_formulas'
                                    , 'vCampo25_conexiones_metricas_formulas'
                                    , 'vCampo26_conexiones_metricas_formulas'
                                    , 'vCampo27_conexiones_metricas_formulas'
                                    , 'vCampo28_conexiones_metricas_formulas'
                                    , 'vCampo29_conexiones_metricas_formulas'
                                    , 'vCampo30_conexiones_metricas_formulas'
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->wait_calling
                            , $value->wait_calling_login_time
                            , $value->tiempo_entre_llamdadas
                            , $value->break_banio
                            , $value->break_banio_login_time
                            , $value->llamadas_por_hora_promedio
                            , $value->talk
                            , $value->tiempo_entre_llamdadas_permitidos
                            , $value->billable
                            , $value->horas_laborables
                            , $value->billable_entre_tiempo
                            , $value->hrs_tope_facturable
                            , $value->conversacion
                            , $value->decimal
                            , $value->rol
                            , $value->campania
                            , $value->vCampo17_conexiones_metricas_formulas
                            , $value->vCampo18_conexiones_metricas_formulas
                            , $value->vCampo19_conexiones_metricas_formulas
                            , $value->vCampo20_conexiones_metricas_formulas
                            , $value->vCampo21_conexiones_metricas_formulas
                            , $value->vCampo22_conexiones_metricas_formulas
                            , $value->vCampo23_conexiones_metricas_formulas
                            , $value->vCampo24_conexiones_metricas_formulas
                            , $value->vCampo25_conexiones_metricas_formulas
                            , $value->vCampo26_conexiones_metricas_formulas
                            , $value->vCampo27_conexiones_metricas_formulas
                            , $value->vCampo28_conexiones_metricas_formulas
                            , $value->vCampo29_conexiones_metricas_formulas
                            , $value->vCampo30_conexiones_metricas_formulas
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
    public function delete_conexiones_metricas_formulas(Request $request)
    {
        $id=$request->id;
        Conexiones_metricas_formulas::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_conexiones_metricas_formulas(Request $request)
    {
        $id=$request->id;
        Conexiones_metricas_formulas::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_conexiones_metricas_formulas()
    {
        Conexiones_metricas_formulas::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
