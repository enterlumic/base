<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratos extends Model
{
    use HasFactory;
    public $table = "contratos";
    protected $fillable =   [     'id'
                                , 'vc_fza_de_venta'
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
                                , 'b_status'
                            ];

    public $timestamps = false;
}
