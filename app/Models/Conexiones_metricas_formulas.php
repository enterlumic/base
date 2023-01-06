<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conexiones_metricas_formulas extends Model
{
    use HasFactory;
    public $table = "conexiones_metricas_formulas";
    protected $fillable =   [     'id'
                                , 'wait_calling'
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
                                , 'b_status'
                            ];

    public $timestamps = false;
}
