<?php

namespace App\Http\Controllers;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Console_gt;
use App\Lib\LibCore;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Console_gtController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;
    public $nombre_del_proyecto;

    /*
    |--------------------------------------------------------------------------
    | Inicializar variables comunes
    |--------------------------------------------------------------------------
    |
    */
    public function __construct(){
        $this->LibCore = new LibCore();
        $this->nombre_del_proyecto = Str::between($_SERVER['DOCUMENT_ROOT'], '/html/', '/public');
    }

    /*
    |--------------------------------------------------------------------------
    | Inicial
    |--------------------------------------------------------------------------
    |
    | Carga solo vista con HTML
    | Todo es controlado por JS console_gt.js
    |
    */
    public function index()
    {
        if(!\Schema::hasTable('console_gt')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla console_gt"));
        }
        $this->LibCore->setSkynet( ['vc_evento'=> 'index_console_gt' , 'vc_info' => "index - console_gt" ] );

        return view('console_gt');
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
    public function set_console_gt(Request $request)
    {
        if(!\Schema::hasTable('console_gt')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Console_gt"));
        }

        $data=[ 'vc_proyecto' => $request->vc_proyecto,
                'vc_nombre_api' => $request->vc_nombre_api,
                'vc_name' => $request->vc_name,
                'vc_info' => $request->vc_info,
        ];

        // Si ya existe solo se actualiza el registro
        if (isset($request->id)){
            $console_gt = Console_gt::where( ['id' => $request->id])->update($data );
            return json_encode(array("b_status"=> true, "vc_message" => "Actualizado correctamente..."));
        }else{ // Nuevo registro
            $console_gt = Console_gt::create( $data );
            return json_encode(array("b_status"=> true, "vc_message" => "Agregado correctamente..."));
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Importar pensado para cat, simple
    |--------------------------------------------------------------------------
    |
    */
    public function set_import_console_gt(Request $request)
    {
        if(!\Schema::hasTable('console_gt')){
            return json_encode(array("b_status"=> false, "vc_message" => "No se encontro la tabla Cat_tipificacion"));
        }

        $this->LibCore->setSkynet( ['vc_evento'=> 'set_import_console_gt' , 'vc_info' => "set_import_console_gt" ] );

        $arr = explode("\r\n", trim( $request->vc_importar ));
         
        for ($i = 0; $i < count($arr); $i++) {
           $line = $arr[$i];

            $data[]=  ['vc_proyecto'=> trim($line)] ;

        }

        Console_gt::truncate();
        Console_gt::insert($data);

        return json_encode(array("b_status"=> true, "vc_message" => "Importado correctamente..."));
    }


    /*
    |--------------------------------------------------------------------------
    | Importar en excel
    |--------------------------------------------------------------------------
    |
    */
    public function importar_console_gt()
    {
        if (file_exists($request->path))
        {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($request->path);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            if (is_array($sheetData) && count($sheetData) > 0)
            {
                unset($arr);
                foreach ($sheetData as $key => $value)
                {
                    if ($key > 2 && !empty($value['A']))
                    {
                        $arr[]= array(   "vc_proyecto"  => $value['A']
                                        ,"vc_nombre_api"  => $value['B']
                                        ,"vc_name"  => $value['D']
                                        ,"vc_info"  => $value['C']
                        );
                    }
                }
            }

            $result= $this->Console_gt_model->importar_console_gt($arr);
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
    public function get_console_gt_by_id(Request $request)
    {
        $data= Console_gt::select('vc_proyecto'
                                    , 'vc_nombre_api'
                                    , 'vc_name'
                                    , 'vc_info'
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
    public function get_console_gt_by_datatable(Request $request)
    {
        if(!\Schema::hasTable('console_gt')){
            return json_encode(array("data"=>"" ));
        }

        $data= Console_gt::select("id"
                                    , "vc_proyecto"
                                    , "vc_nombre_api"
                                    , "vc_name"
                                    , "vc_info"
        )->where('b_status', 1)->get();
        $total= $data->count();

        if($total > 0){

            foreach ($data as $key => $value) {
                $arr[]= array(    $value->id
                                , $value->vc_proyecto
                                , $value->vc_nombre_api
                                , $value->vc_name
                                , $value->vc_info
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
    public function delete_console_gt(Request $request)
    {
        $id=$request->id;
        Console_gt::where('id', $id)->update(['b_status' => 0]);
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
    public function undo_delete_console_gt(Request $request)
    {
        $id=$request->id;
        Console_gt::where('id', $id)->update(['b_status' => 1]);        
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
    public function truncate_console_gt()
    {
        Console_gt::where('b_status', 1)->update(['b_status' => 0]);        
    }

    // qwe

    public function APPLICATION_EXECUTE(Request $request)
    {
        $name_ucfirst     = isset($request->name_strtolower) && !empty($request->name_strtolower) 
                            ? strtolower($request->name_strtolower) : "";
        
        $name_strtolower  = isset($request->name_strtolower) && !empty($request->name_strtolower) 
        ? strtolower($request->name_strtolower) : "";

        $tipo             = isset($request->tipo)       && !empty($request->tipo)       ? strtolower($request->tipo): "form5";
        $controller       = isset($request->controller) && !empty($request->controller) ? $name_strtolower: "";
        $model            = isset($request->model)      && !empty($request->model)      ? $name_strtolower : "";
        $view             = isset($request->view)       && !empty($request->view)       ? $name_strtolower : "";
        $js               = isset($request->js)         && !empty($request->js)         ? $name_strtolower : "";

        $proyecto                  = preg_replace("/[^a-zA-Z0-9]+/", "", $request->proyecto);
        $param                     = array();
        $param["tipo"]             = $tipo;
        $param["proyecto"]         = $proyecto;
        $param["model"]            = strtolower($model);
        $param["view"]             = ucfirst($view) . "_view";
        $param["title"]            = ucfirst($view) . "";
        $param["controller"]       = strtolower($controller);
        $param["name_strtolower"]  = strtolower($name_strtolower);
        $param["name_camel"]       = Str::of($controller)->camel();
        $param["name_ucfirst"]     = ucfirst($name_ucfirst);
        $Camel = Str::of($controller)->camel();

        if( !empty($proyecto) )
        {
            $path_ab= "/var/www/html/".$proyecto;
            $ruta_migrate= "database/migrations/".date("Y_m_d_His")."_".$name_strtolower.".php";

            $param["file_view"]       = $path_ab."/resources/views/".$Camel.".blade.php";
            $param["file_js"]         = $path_ab."/public/assets/js/core_js/".$js.".js";
            $param["file_controller"] = $path_ab."/app/Http/Controllers/".$Camel."Controller.php";
            $param["file_model"]      = $path_ab."/app/Models/".$Camel.".php";
            $param["file_migrate"]    = $path_ab."/".$ruta_migrate;
            $param["file_route"]      = $path_ab."/routes/".strtolower($name_strtolower).".php";
            $API_BD                   = $path_ab."/API_BD/" . strtolower($name_strtolower) . ".sql";
            $param["API_BD"]          = $API_BD;
            $param["file_bd"]         = "/var/www/html/".$this->nombre_del_proyecto."/API_BD/new_bd.sql";
            $param["vc_camel"]        = $Camel;
            $param["bd"]              = $proyecto;

            if ( !file_exists($param["file_model"]) && !empty($model) ){
                $this->create_model_laravel($param);
            }

            if ( !file_exists($param["file_controller"]) && !empty($controller) ){
                $this->create_controller_laravel($param);
            }

            if ( !file_exists($param["file_migrate"]) && $request->migrate){
                $this->create_migrate_laravel($param);
            }

            if ( !file_exists($param["file_js"])  && !empty($js) ){
                $this->create_js_laravel($param);
            }

            if ( !file_exists($param["file_view"]) && !empty($view) ){
                $this->create_view_laravel($param);
            }

            // CREAR BD
            if ( isset($request->sql)&& !empty($request->sql) ){
                $this->create_bd($param);
            }

            $this->save_files_created($param);

            if ( $request->migrate ){
                $migrate= "cd /var/www/html/".$proyecto." && php artisan migrate --path=" . $ruta_migrate;
                file_put_contents("/var/www/html/".$this->nombre_del_proyecto."/sh/LarabelMigrate.sh", $migrate );
                $result= shell_exec('/var/www/html/'.$this->nombre_del_proyecto.'/sh/LarabelMigrate.sh');
            }

            $agregar_ruta = "\n\n// ".date("Y-m-d")  . " gmartinez@tecsa.app \nuse App\Http\Controllers\\".$Camel."Controller;
            Route::get('".$Camel."', [".$Camel."Controller::class, 'index']);
            Route::post('set_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'set_".strtolower($name_strtolower)."']);
            Route::post('set_import_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'set_import_".strtolower($name_strtolower)."']);
            Route::post('get_".strtolower($name_strtolower)."_by_id', [".$Camel."Controller::class, 'get_".strtolower($name_strtolower)."_by_id']);
            Route::post('delete_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'delete_".strtolower($name_strtolower)."']);
            Route::post('undo_delete_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'undo_delete_".strtolower($name_strtolower)."']);
            Route::get('get_".strtolower($name_strtolower)."_by_datatable', [".$Camel."Controller::class, 'get_".strtolower($name_strtolower)."_by_datatable']);
            Route::post('truncate_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'truncate_".strtolower($name_strtolower)."']);
            Route::post('form_importart_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'form_importart_".strtolower($name_strtolower)."']);
            Route::get('export_excel_".strtolower($name_strtolower)."', [".$Camel."Controller::class, 'export_excel_".strtolower($name_strtolower)."']);
            ";

            if (isset($request->route)){

                $web= file_get_contents($path_ab.'/routes/web.php');
                $web= explode("\n", $web);
                $web= array_reverse($web);
                $exists= false;

                foreach ($web as $key => $value) {
                    $exists= Str::contains($value, [strtolower($name_strtolower)]);
                    if ($exists === true)
                        break;
                }

                if ($exists === false){
                    file_put_contents($path_ab.'/routes/web.php', str_replace('    ','',$agregar_ruta) .PHP_EOL , FILE_APPEND | LOCK_EX);
                }
            }

            print_r(json_encode($param["proyecto"]));
            return;
        }

    }

    public function create_controller_laravel($param)
    {
        $file_controller = fopen($param["file_controller"], "w") or die("Unable to open file file_controller AA");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("/var/www/html/maquila/crm_teiker/maquila_controller.php");

        $script = str_replace("%name_camel%", $param["name_camel"], $script);
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);

        fwrite($file_controller, $script);
        chmod($param["file_controller"] ,0777);
    }

    public function create_migrate_laravel($param)
    {
        $file_migrate = fopen($param["file_migrate"], "w") or die("Unable to open file file_controller AA");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("/var/www/html/maquila/crm_teiker/maquila_migrate.php");

        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);

        fwrite($file_migrate, $script);
        chmod($param["file_migrate"] ,0777);
    }

    public function create_model_laravel($param)
    {
        $file_model = fopen($param["file_model"], "w") or die("Unable to open file file_model MM");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("/var/www/html/maquila/crm_teiker/maquila_model.php");

        $script = str_replace("%name_camel%", $param["name_camel"], $script);
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);
        
        fwrite($file_model, $script);
        chmod($param["file_model"] ,0777);
    }

    public function create_view_laravel($param)
    {
        $tipo= $param['tipo'] . "/";        
        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        $file_view = fopen($param["file_view"], "w") or die("Unable to open file file_view!");

        $script = file_get_contents("/var/www/html/maquila/crm_teiker/maquila_view.php");
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%vc_titulo%", str_replace("_", " ", Str::of($param["name_strtolower"])->ucfirst()) , $script);

        fwrite($file_view, $script);
        chmod($param["file_view"] ,0777);
    }

    public function create_js_laravel($param)
    {
        $file_js = fopen($param["file_js"], "w") or die("Unable to open file file_js!");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        
        $script = file_get_contents("/var/www/html/maquila/crm_teiker/maquila_js.js");
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);
        $script = str_replace("%vc_titulo%", str_replace("_", " ", Str::of($param["name_strtolower"])->ucfirst()) , $script);
        
        fwrite($file_js, $script);
        chmod($param["file_js"] ,0777);
    }

    public function create_bd($param)
    {
        $file_bd = fopen($param["file_bd"], "w") or die("Unable to open file file_bd!" );
        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("/var/www/html/".$this->nombre_del_proyecto."/API_BD/crear_bd_laravel.sql");
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);

        fwrite($file_bd, $script);
        copy($param["file_bd"], $param['API_BD']);

        $bd= isset($param['bd']) ? $param['bd'] : '';

        $rm= "mysql -u adminBD -pF4I6^\\\$BDC-aEonn9 ". $bd  ." < /var/www/html/".$param["proyecto"]."/API_BD/".$param["name_strtolower"].".sql";

        file_put_contents("/var/www/html/".$this->nombre_del_proyecto."/sh/crearBD.sh", $rm );

        shell_exec('/var/www/html/'.$this->nombre_del_proyecto.'/sh/crearBD.sh');
    }

    public function save_files_created($postData)
    {
        $this->LibCore->if_exists_sp('sp_set_api_by_lumic', true);

        $proyecto= str_replace("../", "", $postData['proyecto']);
        $rehacer_bd= isset($postData['rehacer_bd']) ? $postData['rehacer_bd'] : '';
        $sql  = "CALL sp_set_api_by_lumic(";
        $sql .= "'" .$proyecto;
        $sql .= "','" .trim( $postData['name_strtolower'] );
        $sql .= "','" .trim( $postData['vc_camel'] );
        $sql .= "','" .trim( $rehacer_bd );
        $sql .= "',  @i_internal_status";
        $sql .= ");";

        $data = DB::select($sql);
    }


    public function get_api_by_lumic()
    {
        $this->LibCore->if_exists_sp('sp_get_api_by_lumic', true);
        $sql = "CALL sp_get_api_by_lumic(0,100000000);";
        $data = DB::select($sql);

        if (is_array($data) && !empty($data)){
            foreach ($data as $key => $value) {
                $arr[]= [$value->id, $value->vc_name, $value->created_at]; 
            }

            return json_encode(array("data"=>$arr));
        }else{
            return json_encode(array("data"=>""));            
        }
    }

    public function reset_api()
    {
        DB::table('console_gt')->truncate();
    }


    public function api_by_id(Request $request)
    {
        $this->LibCore->if_exists_sp('sp_get_api_by_id', true);
        $sql = "CALL sp_get_api_by_id(".$request->id.");";
        $data = DB::select($sql);

        return $data[0];
    }

    public function delete_api_by_lumic(Request $request)
    {
        $this->LibCore->if_exists_sp('sp_delete_api_by_lumic', true);
        $sql = "CALL sp_delete_api_by_lumic(".$request->id.");";
        $data = DB::select($sql);
    }

    public function undo_delete_api_by_lumic($id)
    {

        $sql  = "CALL sp_undo_delete_api_by_lumic(";
        $sql .= intval($id);
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $data = DB::select($sql);

        // $i_internal_status= (array) $this->db->query("SELECT @i_internal_status")->result()[0];

        // return $this->load->response(true, $i_internal_status);
    }
    
    public function set_update_api_by_lumic(Request $request)
    {
        Console_gt::where( ['id' => $request->id])->update( ['vc_name' =>  $request->vc_description_update] );
    }

    public function eliminar_proyecto(Request $request)
    {
        $rm= "cd /var/www/html/".$request->proyecto." \n find -iname *".$request->fileName."*  -type f -exec rm {} \\;\nfind -iname *".$request->fileName2."*  -type f -exec rm {} \\; ";
        file_put_contents("/var/www/html/".$this->nombre_del_proyecto."/sh/del.sh", $rm );
        shell_exec('/var/www/html/'.$this->nombre_del_proyecto.'/sh/del.sh');
        echo $rm;
    }

    public function eliminar_bd(Request $request)
    {
        $nombre_tabla= $request->nombre_tabla;

        $sql= "mysql -u adminBD -pF4I6^\\\$BDC-aEonn9 -e 'USE ".$request->proyecto."; DROP TABLE IF EXISTS ".$nombre_tabla."; DELETE FROM migrations where migration like  \"%_".$nombre_tabla."\"  ;';";

        file_put_contents("/var/www/html/".$this->nombre_del_proyecto."/sh/delBD.sh", $sql );
        shell_exec('/var/www/html/'.$this->nombre_del_proyecto.'/sh/delBD.sh');

        return "Tabla eliminado ". $nombre_tabla;
    }


    public function guardar_sh(Request $request)
    {
        file_put_contents("/var/www/html/".$this->nombre_del_proyecto."/sh/sh.sh", $request->textSSH);
        $result= shell_exec('/var/www/html/'.$this->nombre_del_proyecto.'/sh/sh.sh');
    }
}
