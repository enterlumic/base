<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportventas3 extends Model
{
    use HasFactory;
    public $table = "report_performance_ventas_3";

    protected $fillable = [
        'fecha',
        'user_id',
        'Nombre_Completo',
        'Ingreso',
        'Baja',
        'Ant',
        'Turno',
        'Rol',
        'Centro_Costo',
        'Puesto',
        'Departamento'
    ];
}
