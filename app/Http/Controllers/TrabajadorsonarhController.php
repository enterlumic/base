<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Trabajadorsonarh;
use App\Lib\LibCore;

class TrabajadorsonarhController extends Controller
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
    | Todo es controlado por JS trabajadorsonarh.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('trabajadorsonarh')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla trabajadorsonarh"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_trabajadorsonarh' , 'vc_info' => "index - trabajadorsonarh" ] );

        return view('trabajadorsonarh');
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
    public function set_trabajadorsonarh(Request $request)
    {
        if(!\Schema::hasTable('trabajadorsonarh')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Trabajadorsonarh"));
        }

        $data=[ 'Nombre' => $request->Nombre,
                'Paterno' => $request->Paterno,
                'Materno' => $request->Materno,
                'FechaIngreso' => $request->FechaIngreso,
                'FechaBaja' => $request->FechaBaja,
                'Fecha' => $request->Fecha,
                'De' => $request->De,
                'Nacimiento' => $request->Nacimiento,
                'Centro' => $request->Centro,
                'Costo' => $request->Costo,
                'Departamento' => $request->Departamento,
                'Puesto' => $request->Puesto,
                'Active' => $request->Active,
                'DateCreated' => $request->DateCreated,
                'DateModified' => $request->DateModified,
                'vCampo16_trabajadorsonarh' => $request->vCampo16_trabajadorsonarh,
                'vCampo17_trabajadorsonarh' => $request->vCampo17_trabajadorsonarh,
                'vCampo18_trabajadorsonarh' => $request->vCampo18_trabajadorsonarh,
                'vCampo19_trabajadorsonarh' => $request->vCampo19_trabajadorsonarh,
                'vCampo20_trabajadorsonarh' => $request->vCampo20_trabajadorsonarh,
                'vCampo21_trabajadorsonarh' => $request->vCampo21_trabajadorsonarh,
                'vCampo22_trabajadorsonarh' => $request->vCampo22_trabajadorsonarh,
                'vCampo23_trabajadorsonarh' => $request->vCampo23_trabajadorsonarh,
                'vCampo24_trabajadorsonarh' => $request->vCampo24_trabajadorsonarh,
                'vCampo25_trabajadorsonarh' => $request->vCampo25_trabajadorsonarh,
                'vCampo26_trabajadorsonarh' => $request->vCampo26_trabajadorsonarh,
                'vCampo27_trabajadorsonarh' => $request->vCampo27_trabajadorsonarh,
                'vCampo28_trabajadorsonarh' => $request->vCampo28_trabajadorsonarh,
                'vCampo29_trabajadorsonarh' => $request->vCampo29_trabajadorsonarh,
                'vCampo30_trabajadorsonarh' => $request->vCampo30_trabajadorsonarh,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $trabajadorsonarh = Trabajadorsonarh::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $trabajadorsonarh = Trabajadorsonarh::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_trabajadorsonarh(Request $request)
    {
        if(!\Schema::hasTable('trabajadorsonarh')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_trabajadorsonarh' , 'vc_info' => "set_import_trabajadorsonarh" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['Nombre'=> trim($line)] ;

        }

        Trabajadorsonarh::truncate();
        Trabajadorsonarh::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_trabajadorsonarh()
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
                        $arr[]= array(   "Nombre"  => $value['A']
                                        ,"Paterno"  => $value['B']
                                        ,"Materno"  => $value['D']
                                        ,"FechaIngreso"  => $value['C']
                                        ,"FechaBaja"  => $value['E']
                                        ,"Fecha"  => $value['F']
                                        ,"De"  => $value['G']
                                        ,"Nacimiento"  => $value['H']
                                        ,"Centro"  => $value['I']
                                        ,"Costo" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Trabajadorsonarh_model->importar_trabajadorsonarh($arr);
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
    public function get_trabajadorsonarh_by_id(Request $request)
    {
        $data= Trabajadorsonarh::select('Nombre'
                                    , 'Paterno'
                                    , 'Materno'
                                    , 'FechaIngreso'
                                    , 'FechaBaja'
                                    , 'Fecha'
                                    , 'De'
                                    , 'Nacimiento'
                                    , 'Centro'
                                    , 'Costo'
                                    , 'Departamento'
                                    , 'Puesto'
                                    , 'Active'
                                    , 'DateCreated'
                                    , 'DateModified'
                                    , 'vCampo16_trabajadorsonarh'
                                    , 'vCampo17_trabajadorsonarh'
                                    , 'vCampo18_trabajadorsonarh'
                                    , 'vCampo19_trabajadorsonarh'
                                    , 'vCampo20_trabajadorsonarh'
                                    , 'vCampo21_trabajadorsonarh'
                                    , 'vCampo22_trabajadorsonarh'
                                    , 'vCampo23_trabajadorsonarh'
                                    , 'vCampo24_trabajadorsonarh'
                                    , 'vCampo25_trabajadorsonarh'
                                    , 'vCampo26_trabajadorsonarh'
                                    , 'vCampo27_trabajadorsonarh'
                                    , 'vCampo28_trabajadorsonarh'
                                    , 'vCampo29_trabajadorsonarh'
                                    , 'vCampo30_trabajadorsonarh'
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
    public function get_trabajadorsonarh_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('trabajadorsonarh')){
            return json_encode(array("data"=>"" ));
        }

        $data= Trabajadorsonarh::select("id"
                                    , "Nombre"
                                    , "Paterno"
                                    , "Materno"
                                    , "FechaIngreso"
                                    , "FechaBaja"
                                    , "Fecha"
                                    , "De"
                                    , "Nacimiento"
                                    , "Centro"
                                    , "Costo"
                                    , 'Departamento'
                                    , 'Puesto'
                                    , 'Active'
                                    , 'DateCreated'
                                    , 'DateModified'
                                    , 'vCampo16_trabajadorsonarh'
                                    , 'vCampo17_trabajadorsonarh'
                                    , 'vCampo18_trabajadorsonarh'
                                    , 'vCampo19_trabajadorsonarh'
                                    , 'vCampo20_trabajadorsonarh'
                                    , 'vCampo21_trabajadorsonarh'
                                    , 'vCampo22_trabajadorsonarh'
                                    , 'vCampo23_trabajadorsonarh'
                                    , 'vCampo24_trabajadorsonarh'
                                    , 'vCampo25_trabajadorsonarh'
                                    , 'vCampo26_trabajadorsonarh'
                                    , 'vCampo27_trabajadorsonarh'
                                    , 'vCampo28_trabajadorsonarh'
                                    , 'vCampo29_trabajadorsonarh'
                                    , 'vCampo30_trabajadorsonarh'
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->Nombre
                            , $value->Paterno
                            , $value->Materno
                            , $value->FechaIngreso
                            , $value->FechaBaja
                            , $value->Fecha
                            , $value->De
                            , $value->Nacimiento
                            , $value->Centro
                            , $value->Costo
                            , $value->Departamento
                            , $value->Puesto
                            , $value->Active
                            , $value->DateCreated
                            , $value->DateModified
                            , $value->vCampo16_trabajadorsonarh
                            , $value->vCampo17_trabajadorsonarh
                            , $value->vCampo18_trabajadorsonarh
                            , $value->vCampo19_trabajadorsonarh
                            , $value->vCampo20_trabajadorsonarh
                            , $value->vCampo21_trabajadorsonarh
                            , $value->vCampo22_trabajadorsonarh
                            , $value->vCampo23_trabajadorsonarh
                            , $value->vCampo24_trabajadorsonarh
                            , $value->vCampo25_trabajadorsonarh
                            , $value->vCampo26_trabajadorsonarh
                            , $value->vCampo27_trabajadorsonarh
                            , $value->vCampo28_trabajadorsonarh
                            , $value->vCampo29_trabajadorsonarh
                            , $value->vCampo30_trabajadorsonarh
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
    public function delete_trabajadorsonarh(Request $request)
    {
        $id=$request->id;
        Trabajadorsonarh::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_trabajadorsonarh(Request $request)
    {
        $id=$request->id;
        Trabajadorsonarh::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_trabajadorsonarh()
    {
        Trabajadorsonarh::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
