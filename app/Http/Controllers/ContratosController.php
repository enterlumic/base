<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Contratos;
use App\Lib\LibCore;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
    

class ContratosController extends Controller
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
    | Todo es controlado por JS contratos.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('contratos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla contratos"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_contratos' , 'vc_info' => "index - contratos" ] );

        return view('contratos');
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
    public function set_contratos(Request $request)
    {
        if(!\Schema::hasTable('contratos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Contratos"));
        }

        $data=[ 'vc_fza_de_venta' => $request->vc_fza_de_venta,
                'vc_sisact' => $request->vc_sisact,
                'vc_campania' => $request->vc_campania,
                'vc_cac' => $request->vc_cac,
                'vc_apellido_paterno' => $request->vc_apellido_paterno,
                'vc_apellido_materno' => $request->vc_apellido_materno,
                'vc_nombre' => $request->vc_nombre,
                'dt_fecha_activa' => $request->dt_fecha_activa,
                'vc_plan' => $request->vc_plan,
                'vc_telefono' => $request->vc_telefono,
                'vc_crm' => $request->vc_crm,
                'vc_empleado' => $request->vc_empleado,
                'EMPLEADO' => $request->EMPLEADO,
                'vTema14_contratos' => $request->vTema14_contratos,
                'vCampo15_contratos' => $request->vCampo15_contratos,
                'vCampo16_contratos' => $request->vCampo16_contratos,
                'vCampo17_contratos' => $request->vCampo17_contratos,
                'vCampo18_contratos' => $request->vCampo18_contratos,
                'vCampo19_contratos' => $request->vCampo19_contratos,
                'vCampo20_contratos' => $request->vCampo20_contratos,
                'vCampo21_contratos' => $request->vCampo21_contratos,
                'vCampo22_contratos' => $request->vCampo22_contratos,
                'vCampo23_contratos' => $request->vCampo23_contratos,
                'vCampo24_contratos' => $request->vCampo24_contratos,
                'vCampo25_contratos' => $request->vCampo25_contratos,
                'vCampo26_contratos' => $request->vCampo26_contratos,
                'vCampo27_contratos' => $request->vCampo27_contratos,
                'vCampo28_contratos' => $request->vCampo28_contratos,
                'vCampo29_contratos' => $request->vCampo29_contratos,
                'vCampo30_contratos' => $request->vCampo30_contratos,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $contratos = Contratos::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $contratos = Contratos::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_contratos(Request $request)
    {
        if(!\Schema::hasTable('contratos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_contratos' , 'vc_info' => "set_import_contratos" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['vc_fza_de_venta'=> trim($line)] ;

        }

        Contratos::truncate();
        Contratos::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function FormImportarContratos(Request $request)
    {

        sleep(2);
        if (!empty($request->file('files'))){
            $path = Storage::putFile( 'public/ReporteExcel/', $request->file('files') );
        }

        if (!empty($path)){
            $this->LibCore->setSkynet(['vc_evento'=> 'uploadExcelSuccess' , 'vc_info' => "<b>Subiendo Excel ok </b> ". $path ] );

            ////////////////////////////////////////
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load( Storage::path($path ) );
            $d=$spreadsheet->getSheet(0)->toArray();
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $i=1;
            unset($sheetData[0]);

            foreach ($sheetData as $t) {
                $arr[]= array( 'vc_fza_de_venta'=> isset($t[0]) ? $t[0] : ''
                             , 'vc_sisact'=> isset($t[1]) ? $t[1] : ''
                             , 'vc_campania'=> isset($t[2]) ? $t[2] : ''
                             , 'vc_cac'=> isset($t[3]) ? $t[3] : ''
                             , 'vc_apellido_paterno'=> isset($t[4]) ? $t[4] : ''
                             , 'vc_apellido_materno'=> isset($t[5]) ? $t[5] : ''
                             , 'vc_nombre'=> isset($t[6]) ? $t[6] : ''
                             , 'dt_fecha_activa'=> isset($t[7]) ? $t[7] : ''
                             , 'vc_plan'=> isset($t[8]) ? $t[8] : ''
                             , 'vc_telefono'=> isset($t[9]) ? $t[9] : ''
                             , 'vc_crm'=> isset($t[10]) ? $t[10] : ''
                             , 'vc_empleado'=> isset($t[11]) ? $t[11] : ''
                             , 'EMPLEADO'=> isset($t[12]) ? $t[12] : ''
                             , 'vTema14_contratos'=> isset($t[13]) ? $t[13] : ''
                             , 'vCampo15_contratos'=> isset($t[14]) ? $t[14] : ''
                );
                $i++;
            }

            Contratos::insert($arr);
            ////////////////////////////////////////

            return json_encode(array("b_status"=> true, "data" => [ "vc_path" =>  Storage::url( $path )  ] ));
        }

        return json_encode(array("b_status"=> false, "data" => [ "vc_message" => 'No se adjunto algun archivo' ] ));
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener un registro por id
    |--------------------------------------------------------------------------
    | 
    | @return json
    |
    */
    public function get_contratos_by_id(Request $request)
    {
        $data= Contratos::select('vc_fza_de_venta'
                                    , 'vc_sisact'
                                    , 'vc_campania'
                                    , 'vc_cac'
                                    , 'vc_apellido_paterno'
                                    , 'vc_apellido_materno'
                                    , 'vc_nombre'
                                    , 'dt_fecha_activa'
                                    , 'vc_plan'
                                    , 'vc_telefono'
                                    , 'vc_crm'
                                    , 'vc_empleado'
                                    , 'EMPLEADO'
                                    , 'vTema14_contratos'
                                    , 'vCampo15_contratos'
                                    , 'vCampo16_contratos'
                                    , 'vCampo17_contratos'
                                    , 'vCampo18_contratos'
                                    , 'vCampo19_contratos'
                                    , 'vCampo20_contratos'
                                    , 'vCampo21_contratos'
                                    , 'vCampo22_contratos'
                                    , 'vCampo23_contratos'
                                    , 'vCampo24_contratos'
                                    , 'vCampo25_contratos'
                                    , 'vCampo26_contratos'
                                    , 'vCampo27_contratos'
                                    , 'vCampo28_contratos'
                                    , 'vCampo29_contratos'
                                    , 'vCampo30_contratos'
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
    public function get_contratos_by_datatable()
    {
        if(!\Schema::hasTable('contratos')){
            return json_encode(array("data"=>"" ));
        }

        $data= Contratos::select("id"
                                    , "vc_fza_de_venta"
                                    , "vc_sisact"
                                    , "vc_campania"
                                    , "vc_cac"
                                    , "vc_apellido_paterno"
                                    , "vc_apellido_materno"
                                    , "vc_nombre"
                                    , "dt_fecha_activa"
                                    , "vc_plan"
                                    , "vc_telefono"
                                    , 'vc_crm'
                                    , 'vc_empleado'
                                    , 'EMPLEADO'
                                    , 'vTema14_contratos'
                                    , 'vCampo15_contratos'
                                    , 'vCampo16_contratos'
                                    , 'vCampo17_contratos'
                                    , 'vCampo18_contratos'
                                    , 'vCampo19_contratos'
                                    , 'vCampo20_contratos'
                                    , 'vCampo21_contratos'
                                    , 'vCampo22_contratos'
                                    , 'vCampo23_contratos'
                                    , 'vCampo24_contratos'
                                    , 'vCampo25_contratos'
                                    , 'vCampo26_contratos'
                                    , 'vCampo27_contratos'
                                    , 'vCampo28_contratos'
                                    , 'vCampo29_contratos'
                                    , 'vCampo30_contratos'
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->vc_fza_de_venta
                            , $value->vc_sisact
                            , $value->vc_campania
                            , $value->vc_cac
                            , $value->vc_apellido_paterno
                            , $value->vc_apellido_materno
                            , $value->vc_nombre
                            , $value->dt_fecha_activa
                            , $value->vc_plan
                            , $value->vc_telefono
                            , $value->vc_crm
                            , $value->vc_empleado
                            , $value->EMPLEADO
                            , $value->vTema14_contratos
                            , $value->vCampo15_contratos
                            , $value->vCampo16_contratos
                            , $value->vCampo17_contratos
                            , $value->vCampo18_contratos
                            , $value->vCampo19_contratos
                            , $value->vCampo20_contratos
                            , $value->vCampo21_contratos
                            , $value->vCampo22_contratos
                            , $value->vCampo23_contratos
                            , $value->vCampo24_contratos
                            , $value->vCampo25_contratos
                            , $value->vCampo26_contratos
                            , $value->vCampo27_contratos
                            , $value->vCampo28_contratos
                            , $value->vCampo29_contratos
                            , $value->vCampo30_contratos
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
    public function delete_contratos(Request $request)
    {
        $id=$request->id;
        Contratos::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_contratos(Request $request)
    {
        $id=$request->id;
        Contratos::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_contratos()
    {
        Contratos::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
