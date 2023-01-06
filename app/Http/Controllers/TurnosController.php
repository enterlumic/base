<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Turnos;
use App\Lib\LibCore;

class TurnosController extends Controller
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
    | Todo es controlado por JS turnos.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('turnos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla turnos"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_turnos' , 'vc_info' => "index - turnos" ] );

        return view('turnos');
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
    public function set_turnos($key, $request)
    {
        if(!\Schema::hasTable('turnos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Turnos"));
        }

        return 
        [       'IdTrab' => $request[$key]->IdTrab,
                'Gestor' => $request[$key]->Gestor,
                'Ingreso' => $request[$key]->Ingreso,
                'Descripcion' => $request[$key]->Descripcion,
                'Descripcion2' => $request[$key]->Descripcion,
                'Rol' => $request[$key]->Rol,
                'Departamento' => $request[$key]->Departamento,
                'Puesto' => $request[$key]->Puesto,
                'Centro_Costo' => $request[$key]->Centro_Costo,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_turnos(Request $request)
    {
        if(!\Schema::hasTable('turnos')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_turnos' , 'vc_info' => "set_import_turnos" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['IdTrab'=> trim($line)] ;

        }

        Turnos::truncate();
        Turnos::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));

    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_turnos()
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
                        $arr[]= array(   "IdTrab"  => $value['A']
                                        ,"Gestor"  => $value['B']
                                        ,"Ingreso"  => $value['D']
                                        ,"Descripcion"  => $value['C']
                                        ,"Descripcion"  => $value['E']
                                        ,"Rol"  => $value['F']
                                        ,"Departamento"  => $value['G']
                                        ,"Puesto"  => $value['H']
                                        ,"Centro_Costo"  => $value['I']
                        );
                    }
                }
            }

            $result= $this->Turnos_model->importar_turnos($arr);
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
    public function get_turnos_by_id(Request $request)
    {
        $data= Turnos::select('IdTrab'
                                    , 'Gestor'
                                    , 'Ingreso'
                                    , 'Descripcion'
                                    , 'Descripcion'
                                    , 'Rol'
                                    , 'Departamento'
                                    , 'Puesto'
                                    , 'Centro_Costo'
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
    public function get_turnos_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('turnos')){
            return json_encode(array("data"=>"" ));
        }

        $data= Turnos::select("id"
                                    , "IdTrab"
                                    , "Gestor"
                                    , "Ingreso"
                                    , "Descripcion"
                                    , "Descripcion"
                                    , "Rol"
                                    , "Departamento"
                                    , "Puesto"
                                    , "Centro_Costo"
        );

        $total  = $data->count();

        foreach ($data->where('b_status', 1)->get() as $key => $value) {
            $arr[]= array(    $value->id
                            , $value->IdTrab
                            , $value->Gestor
                            , $value->Ingreso
                            , $value->Descripcion
                            , $value->Descripcion
                            , $value->Rol
                            , $value->Departamento
                            , $value->Puesto
                            , $value->Centro_Costo
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
    public function delete_turnos(Request $request)
    {
        $id=$request->id;
        Turnos::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_turnos(Request $request)
    {
        $id=$request->id;
        Turnos::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_turnos()
    {
        Turnos::where('b_status', 1)->update(['b_status' => 0]);        
    }
}
