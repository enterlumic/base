<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteMetricasYConexiones extends Model
{
    use HasFactory;
    public $table = "reporte_metricas_y_conexiones";
    protected $fillable =   [     'id'
                                , 'fecha'
                                , 'horas_r'
                                , 'promedio_billiable_x_agente'
                                , 'faltas'
                                , 'tope_de_hrs_x_dia'
                                , 'hrs_fact'
                                , 'dif_hrs_top'
                                , 'fac_hrs_tope'
                                , 'DIFERENCIA_HRS_HC'
                                , 'FACT_HRS_TOPE__HRS_FACT_REALES'
                            ];

    public $timestamps = false;
}
