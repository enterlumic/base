<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/welcome')->middleware('auth');


use App\Http\Controllers\Dashboard;
Route::get('/dashboard', [Dashboard::class, 'index'])->middleware('auth');
Route::get('cron_reporte', [Dashboard::class, 'cron_reporte']);
Route::get('_login', [Dashboard::class, '_login']);

require __DIR__.'/auth.php';

// 2022-09-29 gmartinez@tecsa.app 
use App\Http\Controllers\DesepenioController;
Route::get('desepenio', [DesepenioController::class, 'index']);
Route::get('get_desepenio_by_datatable', [DesepenioController::class, 'get_desepenio_by_datatable']);
Route::post('truncate_desepenio', [DesepenioController::class, 'truncate_desepenio']);
Route::post('calendar_desempeno', [DesepenioController::class, 'calendar_desempeno'])->middleware('auth');
Route::get('exportarExcel', [DesepenioController::class, 'exportarExcel'])->middleware('auth');
Route::get('export', [DesepenioController::class, 'export'])->middleware('auth');
Route::post('eliminar_archivo_ya_exportado', [DesepenioController::class, 'eliminar_archivo_ya_exportado'])->middleware('auth');

use App\Http\Controllers\SkynetController;
Route::get('skynet', [SkynetController::class, 'index']);
Route::get('get_skynet_by_datatable', [SkynetController::class, 'get_skynet_by_datatable']);
Route::post('truncate_Skynet', [SkynetController::class, 'truncate_Skynet']);
Route::get('validar_debug', [SkynetController::class, 'validar_debug']);

use App\Http\Controllers\Perfil_usuarioController;
Route::get('perfil_usuario', [Perfil_usuarioController::class, 'index'])->middleware('auth');
Route::post('set_perfil_usuario', [Perfil_usuarioController::class, 'set_perfil_usuario'])->middleware('auth');
Route::get('get_perfil_usuario_by_id', [Perfil_usuarioController::class, 'get_perfil_usuario_by_id'])->middleware('auth');
Route::post('delete_perfil_usuario', [Perfil_usuarioController::class, 'delete_perfil_usuario'])->middleware('auth');
Route::post('undo_delete_perfil_usuario', [Perfil_usuarioController::class, 'undo_delete_perfil_usuario'])->middleware('auth');
Route::get('get_perfil_usuario_by_datatable', [Perfil_usuarioController::class, 'get_perfil_usuario_by_datatable'])->middleware('auth');

Route::post('uploadFiles', [Perfil_usuarioController::class, 'uploadFiles'])->middleware('auth');
Route::post('eliminarFotoPerfil', [Perfil_usuarioController::class, 'eliminarFotoPerfil'])->middleware('auth');

// 2022-10-03 gmartinez@tecsa.app 
use App\Http\Controllers\Control_a_cerosController;
Route::get('control_a_ceros', [Control_a_cerosController::class, 'index']);
Route::get('get_control_a_ceros_by_datatable', [Control_a_cerosController::class, 'get_control_a_ceros_by_datatable']);
Route::get('get_control_a_ceros_by_datatable_full', [Control_a_cerosController::class, 'get_control_a_ceros_by_datatable_full']);
Route::get('get_uso_de_sistema_by_datatable', [Control_a_cerosController::class, 'get_uso_de_sistema_by_datatable']);
Route::get('exportarControlACerosExcel', [Control_a_cerosController::class, 'exportarControlACerosExcel']);
Route::get('test', [Control_a_cerosController::class, 'test']);
Route::get('get_control_a_ceros_by_excel', [Control_a_cerosController::class, 'get_control_a_ceros_by_excel']);
Route::get('get_control_a_ceros_by_excel_full', [Control_a_cerosController::class, 'get_control_a_ceros_by_excel_full']);

// 2022-10-11 gmartinez@tecsa.app 
use App\Http\Controllers\Sql_serverController;
Route::get('sql_server', [Sql_serverController::class, 'index']);
Route::post('set_sql_server', [Sql_serverController::class, 'set_sql_server']);
Route::post('set_import_sql_server', [Sql_serverController::class, 'set_import_sql_server']);
Route::post('get_sql_server_by_id', [Sql_serverController::class, 'get_sql_server_by_id']);
Route::post('delete_sql_server', [Sql_serverController::class, 'delete_sql_server']);
Route::post('undo_delete_sql_server', [Sql_serverController::class, 'undo_delete_sql_server']);
Route::get('get_sql_server_by_datatable', [Sql_serverController::class, 'get_sql_server_by_datatable']);
Route::get('sp', [Sql_serverController::class, 'sp']);
Route::get('info', [Sql_serverController::class, 'info']);

// 2022-10-15 gmartinez@tecsa.app 
use App\Http\Controllers\AjustesController;
Route::get('ajustes', [AjustesController::class, 'index']);
Route::post('set_ajustes', [AjustesController::class, 'set_ajustes']);
Route::post('set_import_ajustes', [AjustesController::class, 'set_import_ajustes']);
Route::post('get_ajustes_by_id', [AjustesController::class, 'get_ajustes_by_id']);
Route::post('delete_ajustes', [AjustesController::class, 'delete_ajustes']);
Route::post('undo_delete_ajustes', [AjustesController::class, 'undo_delete_ajustes']);
Route::get('get_ajustes_by_datatable', [AjustesController::class, 'get_ajustes_by_datatable']);
Route::post('truncate_ajustes', [AjustesController::class, 'truncate_ajustes']);

// 2022-10-27 gmartinez@tecsa.app 
use App\Http\Controllers\ContratosController;
Route::get('contratos', [ContratosController::class, 'index']);
Route::post('set_contratos', [ContratosController::class, 'set_contratos']);
Route::post('set_import_contratos', [ContratosController::class, 'set_import_contratos']);
Route::post('get_contratos_by_id', [ContratosController::class, 'get_contratos_by_id']);
Route::post('delete_contratos', [ContratosController::class, 'delete_contratos']);
Route::post('undo_delete_contratos', [ContratosController::class, 'undo_delete_contratos']);
Route::get('get_contratos_by_datatable', [ContratosController::class, 'get_contratos_by_datatable']);
Route::post('truncate_contratos', [ContratosController::class, 'truncate_contratos']);
Route::post('FormImportarContratos', [ContratosController::class, 'FormImportarContratos']);

// 2022-10-28 gmartinez@tecsa.app 
use App\Http\Controllers\Enviar_correo_al_cargar_reporteController;
Route::get('enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'index']);
Route::post('set_enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'set_enviar_correo_al_cargar_reporte']);
Route::post('set_import_enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'set_import_enviar_correo_al_cargar_reporte']);
Route::post('get_enviar_correo_al_cargar_reporte_by_id', [Enviar_correo_al_cargar_reporteController::class, 'get_enviar_correo_al_cargar_reporte_by_id']);
Route::post('delete_enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'delete_enviar_correo_al_cargar_reporte']);
Route::post('undo_delete_enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'undo_delete_enviar_correo_al_cargar_reporte']);
Route::get('get_enviar_correo_al_cargar_reporte_by_datatable', [Enviar_correo_al_cargar_reporteController::class, 'get_enviar_correo_al_cargar_reporte_by_datatable']);
Route::post('truncate_enviar_correo_al_cargar_reporte', [Enviar_correo_al_cargar_reporteController::class, 'truncate_enviar_correo_al_cargar_reporte']);



// 2022-10-31 gmartinez@tecsa.app 
use App\Http\Controllers\Carrier_statusController;
Route::get('carrier_status', [Carrier_statusController::class, 'index']);
Route::post('set_carrier_status', [Carrier_statusController::class, 'set_carrier_status']);
Route::post('set_import_carrier_status', [Carrier_statusController::class, 'set_import_carrier_status']);
Route::post('get_carrier_status_by_id', [Carrier_statusController::class, 'get_carrier_status_by_id']);
Route::post('delete_carrier_status', [Carrier_statusController::class, 'delete_carrier_status']);
Route::post('undo_delete_carrier_status', [Carrier_statusController::class, 'undo_delete_carrier_status']);
Route::get('get_carrier_status_by_datatable', [Carrier_statusController::class, 'get_carrier_status_by_datatable']);
Route::post('truncate_carrier_status', [Carrier_statusController::class, 'truncate_carrier_status']);


// 2022-10-31 gmartinez@tecsa.app 
use App\Http\Controllers\xController;
Route::get('x', [xController::class, 'index']);
Route::get('sql', [xController::class, 'sql']);

// 2022-11-10 gmartinez@tecsa.app 
use App\Http\Controllers\Agentes_por_horaController;
Route::get('agentes_por_hora', [Agentes_por_horaController::class, 'index'])->middleware('auth');
Route::get('get_agentes_por_hora_by_datatable', [Agentes_por_horaController::class, 'get_agentes_por_hora_by_datatable'])->middleware('auth');
Route::get('get_graficar_agentes_por_hora', [Agentes_por_horaController::class, 'get_graficar_agentes_por_hora'])->middleware('auth');
Route::get('get_graficar_agentes_por_hora_home_office_office', [Agentes_por_horaController::class, 'get_graficar_agentes_por_hora_home_office_office'])->middleware('auth');

// 2022-11-22 gmartinez@tecsa.app 
use App\Http\Controllers\Contacto_cronController;
Route::get('contacto_cron', [Contacto_cronController::class, 'index']);
Route::post('set_contacto_cron', [Contacto_cronController::class, 'set_contacto_cron']);
Route::post('set_import_contacto_cron', [Contacto_cronController::class, 'set_import_contacto_cron']);
Route::post('get_contacto_cron_by_id', [Contacto_cronController::class, 'get_contacto_cron_by_id']);
Route::post('delete_contacto_cron', [Contacto_cronController::class, 'delete_contacto_cron']);
Route::post('undo_delete_contacto_cron', [Contacto_cronController::class, 'undo_delete_contacto_cron']);
Route::get('get_contacto_cron_by_datatable', [Contacto_cronController::class, 'get_contacto_cron_by_datatable']);
Route::post('truncate_contacto_cron', [Contacto_cronController::class, 'truncate_contacto_cron']);

use App\Http\Controllers\CoreController;
Route::get('python', [CoreController::class, 'python']);
Route::get('coreExportarExcel', [CoreController::class, 'coreExportarExcel']);

// 2022-11-24 gmartinez@tecsa.app 
use App\Http\Controllers\Metricas_conexionesController;
Route::get('metricas_conexiones', [Metricas_conexionesController::class, 'index']);
Route::post('set_metricas_conexiones', [Metricas_conexionesController::class, 'set_metricas_conexiones']);
Route::post('set_import_metricas_conexiones', [Metricas_conexionesController::class, 'set_import_metricas_conexiones']);
Route::post('get_metricas_conexiones_by_id', [Metricas_conexionesController::class, 'get_metricas_conexiones_by_id']);
Route::post('delete_metricas_conexiones', [Metricas_conexionesController::class, 'delete_metricas_conexiones']);
Route::post('undo_delete_metricas_conexiones', [Metricas_conexionesController::class, 'undo_delete_metricas_conexiones']);
Route::get('get_metricas_conexiones_by_datatable', [Metricas_conexionesController::class, 'get_metricas_conexiones_by_datatable']);
Route::post('truncate_metricas_conexiones', [Metricas_conexionesController::class, 'truncate_metricas_conexiones']);
Route::get('get_reporte_metricas_y_conexiones', [Metricas_conexionesController::class, 'get_reporte_metricas_y_conexiones']);
Route::get('generarReporteExcel', [Metricas_conexionesController::class, 'generarReporteExcel']);

// 2022-11-29 gmartinez@tecsa.app 
use App\Http\Controllers\TurnosController;
Route::get('turnos', [TurnosController::class, 'index']);
Route::post('set_turnos', [TurnosController::class, 'set_turnos']);
Route::post('set_import_turnos', [TurnosController::class, 'set_import_turnos']);

// 2022-11-30 gmartinez@tecsa.app 
use App\Http\Controllers\Conexiones_metricas_formulasController;
Route::get('conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'index']);
Route::post('set_conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'set_conexiones_metricas_formulas']);
Route::post('set_import_conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'set_import_conexiones_metricas_formulas']);
Route::post('get_conexiones_metricas_formulas_by_id', [Conexiones_metricas_formulasController::class, 'get_conexiones_metricas_formulas_by_id']);
Route::post('delete_conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'delete_conexiones_metricas_formulas']);
Route::post('undo_delete_conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'undo_delete_conexiones_metricas_formulas']);
Route::get('get_conexiones_metricas_formulas_by_datatable', [Conexiones_metricas_formulasController::class, 'get_conexiones_metricas_formulas_by_datatable']);
Route::post('truncate_conexiones_metricas_formulas', [Conexiones_metricas_formulasController::class, 'truncate_conexiones_metricas_formulas']);

// 2022-12-02 gmartinez@tecsa.app 
use App\Http\Controllers\TrabajadorsonarhController;
Route::get('trabajadorsonarh', [TrabajadorsonarhController::class, 'index']);
Route::post('set_trabajadorsonarh', [TrabajadorsonarhController::class, 'set_trabajadorsonarh']);
Route::post('set_import_trabajadorsonarh', [TrabajadorsonarhController::class, 'set_import_trabajadorsonarh']);
Route::post('get_trabajadorsonarh_by_id', [TrabajadorsonarhController::class, 'get_trabajadorsonarh_by_id']);
Route::post('delete_trabajadorsonarh', [TrabajadorsonarhController::class, 'delete_trabajadorsonarh']);
Route::post('undo_delete_trabajadorsonarh', [TrabajadorsonarhController::class, 'undo_delete_trabajadorsonarh']);
Route::get('get_trabajadorsonarh_by_datatable', [TrabajadorsonarhController::class, 'get_trabajadorsonarh_by_datatable']);
Route::post('truncate_trabajadorsonarh', [TrabajadorsonarhController::class, 'truncate_trabajadorsonarh']);

// 2022-11-25 ealvarez@tecsa.mx
use App\Http\Controllers\Ventas_servicios_264Controller;
Route::get('ventas_servicios_264', [Ventas_servicios_264Controller::class, 'index']);
Route::get('get_ventas_servicios_264_by_datatable', [Ventas_servicios_264Controller::class, 'get_ventas_servicios_264_by_datatable']);
Route::get('get_ventas_servicios_264_by_excel', [Ventas_servicios_264Controller::class, 'get_ventas_servicios_264_by_excel']);

// 2022-12-13 gmartinez@tecsa.app 
use App\Http\Controllers\Cortes_por_horaController;
Route::get('cortes_por_hora', [Cortes_por_horaController::class, 'index']);
Route::post('set_cortes_por_hora', [Cortes_por_horaController::class, 'set_cortes_por_hora']);
Route::post('set_import_cortes_por_hora', [Cortes_por_horaController::class, 'set_import_cortes_por_hora']);
Route::post('get_cortes_por_hora_by_id', [Cortes_por_horaController::class, 'get_cortes_por_hora_by_id']);
Route::post('delete_cortes_por_hora', [Cortes_por_horaController::class, 'delete_cortes_por_hora']);
Route::post('undo_delete_cortes_por_hora', [Cortes_por_horaController::class, 'undo_delete_cortes_por_hora']);
Route::get('get_cortes_por_hora_by_datatable', [Cortes_por_horaController::class, 'get_cortes_por_hora_by_datatable']);
Route::post('truncate_cortes_por_hora', [Cortes_por_horaController::class, 'truncate_cortes_por_hora']);


// 2022-12-16 gmartinez@tecsa.app 
use App\Http\Controllers\UsersController;
Route::get('usuarios', [UsersController::class, 'index']);
Route::post('set_usuarios', [UsersController::class, 'set_usuarios']);
Route::post('set_import_usuarios', [UsersController::class, 'set_import_usuarios']);
Route::post('get_usuarios_by_id', [UsersController::class, 'get_usuarios_by_id']);
Route::post('delete_usuarios', [UsersController::class, 'delete_usuarios']);
Route::post('undo_delete_usuarios', [UsersController::class, 'undo_delete_usuarios']);
Route::get('get_usuarios_by_datatable', [UsersController::class, 'get_usuarios_by_datatable']);
Route::post('truncate_usuarios', [UsersController::class, 'truncate_usuarios']);

// 2022-12-28 gmartinez@tecsa.app 
use App\Http\Controllers\Console_gtController;
Route::get('console_gt', [Console_gtController::class, 'index']);
Route::post('set_console_gt', [Console_gtController::class, 'set_console_gt']);
Route::post('set_import_console_gt', [Console_gtController::class, 'set_import_console_gt']);
Route::post('get_console_gt_by_id', [Console_gtController::class, 'get_console_gt_by_id']);
Route::post('delete_console_gt', [Console_gtController::class, 'delete_console_gt']);
Route::post('undo_delete_console_gt', [Console_gtController::class, 'undo_delete_console_gt']);
Route::get('get_console_gt_by_datatable', [Console_gtController::class, 'get_console_gt_by_datatable']);
Route::post('truncate_console_gt', [Console_gtController::class, 'truncate_console_gt']);
Route::post('APPLICATION_EXECUTE', [Console_gtController::class, 'APPLICATION_EXECUTE']);
Route::get('get_api_by_lumic', [Console_gtController::class, 'get_api_by_lumic']);
Route::post('reset_api', [Console_gtController::class, 'reset_api']);
Route::post('eliminar_proyecto', [Console_gtController::class, 'eliminar_proyecto']);
Route::post('eliminar_bd', [Console_gtController::class, 'eliminar_bd']);
Route::post('api_by_id', [Console_gtController::class, 'api_by_id']);
Route::post('set_update_api_by_lumic', [Console_gtController::class, 'set_update_api_by_lumic']);
Route::post('guardar_sh', [Console_gtController::class, 'guardar_sh']);
Route::post('delete_api_by_lumic', [Console_gtController::class, 'delete_api_by_lumic']);

// 2023-01-04 gmartinez@tecsa.app 
use App\Http\Controllers\comandosController;
Route::get('comandos', [comandosController::class, 'index']);
Route::post('set_comandos', [comandosController::class, 'set_comandos']);
Route::post('set_import_comandos', [comandosController::class, 'set_import_comandos']);
Route::post('get_comandos_by_id', [comandosController::class, 'get_comandos_by_id']);
Route::post('delete_comandos', [comandosController::class, 'delete_comandos']);
Route::post('undo_delete_comandos', [comandosController::class, 'undo_delete_comandos']);
Route::get('get_comandos_by_datatable', [comandosController::class, 'get_comandos_by_datatable']);
Route::post('truncate_comandos', [comandosController::class, 'truncate_comandos']);
Route::post('form_importart_comandos', [comandosController::class, 'form_importart_comandos']);

