<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportventas1 extends Model
{
    use HasFactory;
    public $table = "report_performance_ventas_1";

    protected $fillable = [
        'fecha',
        'user_id',
        'agent_time',
        'brk',
        'jun',
        'ba',
        'Horas_Efectivas',
        'Promedio TIempo_Efectivo'
    ];
}