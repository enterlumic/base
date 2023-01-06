<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Contacto_cron;
use App\Lib\LibCore;

class Contacto_cronController extends Controller
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
    | Todo es controlado por JS contacto_cron.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('contacto_cron')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla contacto_cron"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_contacto_cron' , 'vc_info' => "index - contacto_cron" ] );

        return view('contacto_cron');
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
    public function set_contacto_cron(Request $request)
    {
        if(!\Schema::hasTable('contacto_cron')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Contacto_cron"));
        }

        $data=[ 'vc_nombre' => $request->vc_nombre,
                'vc_correo' => $request->vc_correo,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $contacto_cron = Contacto_cron::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $contacto_cron = Contacto_cron::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_contacto_cron(Request $request)
    {
        if(!\Schema::hasTable('contacto_cron')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_contacto_cron' , 'vc_info' => "set_import_contacto_cron" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['vc_nombre'=> trim($line)] ;

        }

        Contacto_cron::truncate();
        Contacto_cron::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_contacto_cron()
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
                        $arr[]= array(   "vc_nombre"  => $value['A']
                                        ,"vc_correo"  => $value['B']
                        );
                    }
                }
            }

            $result= $this->Contacto_cron_model->importar_contacto_cron($arr);
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
    public function get_contacto_cron_by_id(Request $request)
    {
        $data= Contacto_cron::select('vc_nombre'
                                    , 'vc_correo'
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
    public function get_contacto_cron_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('contacto_cron')){
            return json_encode(array("data"=>"" ));
        }

        $data= Contacto_cron::select("id"
                                    , "vc_nombre"
                                    , "vc_correo"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_nombre
                            , $value->vc_correo
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
    public function delete_contacto_cron(Request $request)
    {
        $id=$request->id;
        Contacto_cron::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_contacto_cron(Request $request)
    {
        $id=$request->id;
        Contacto_cron::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_contacto_cron()
    {
        Contacto_cron::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
