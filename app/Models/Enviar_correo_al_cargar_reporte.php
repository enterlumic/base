<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enviar_correo_al_cargar_reporte extends Model
{
    use HasFactory;
    public $table = "enviar_correo_al_cargar_reporte";
    protected $fillable =   [     'id'
                                , 'vc_correo'
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
                                , 'b_status'
                            ];

    public $timestamps = false;
}
