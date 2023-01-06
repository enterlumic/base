<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte_agentes_por_hora extends Model
{
    use HasFactory;
    public $table = "reporte_agentes_por_hora";
    protected $fillable =   [   "id" ,
                                "total" ,
                                "hora_8" ,
                                "hora_9" ,
                                "hora_10" ,
                                "hora_11" ,
                                "hora_12" ,
                                "hora_13" ,
                                "hora_14" ,
                                "hora_15" ,
                                "hora_16" ,
                                "hora_17" ,
                                "hora_18" ,
                                "hora_19" ,
                                "hora_20" ,
                                "hora_21"
                            ];

    public $timestamps = false;
}